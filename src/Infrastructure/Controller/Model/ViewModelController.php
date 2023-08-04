<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Model;

use App\Application\Attribute\Builder\AttributeGenericBuilder;
use App\Application\CommandBusInterface;
use App\Application\Model\Command\CreateCodeTacCommand;
use App\Domain\Model\Model;
use App\Domain\ModelEntity\Exception\CodeTacAlreadyExistsException;
use App\Domain\ModelEntity\Repository\CodeTacRepositoryInterface;
use App\Infrastructure\Form\Model\CreateCodeTacFormType;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

final class ViewModelController
{
    public function __construct(
        private \Twig\Environment $twig,
        private RouterInterface $router,
        private CodeTacRepositoryInterface $codeTacRepository,
        private FormFactoryInterface $formFactory,
        private AttributeGenericBuilder $attributeBuilder,
        private CommandBusInterface $commandBus,
        private TranslatorInterface $translator,
    ) {
    }

    #[Route('/series/{serie}/models/{model}', name: 'app_model_view', methods: ['GET', 'POST'])]
    public function __invoke(Request $request, Model $model): Response
    {
        $command = new CreateCodeTacCommand($model);
        $formCodeTac = $this->formFactory->create(CreateCodeTacFormType::class, $command);

        $formCodeTac->handleRequest($request);

        $response = new Response();

        try {
            if ($formCodeTac->isSubmitted()) {
                if ($formCodeTac->isValid()) {
                    $this->commandBus->handle($command);

                    return new RedirectResponse($request->getUri());
                }

                $response->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        } catch (CodeTacAlreadyExistsException) {
            $errorMsg = $this->translator->trans('models.codeTac.create.form.codeTac.alreadyExists', [], 'validators');
            $formCodeTac->get('codeTac')->addError(new FormError($errorMsg));
            $response->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $codeTacs = $this->codeTacRepository->findCodeTacs($model);

        $response->setContent($this->twig->render(
            name: 'models/view.html.twig',
            context: [
                'model' => $model,
                'allAttributeNames' => AttributeGenericBuilder::getAllAttributeNames(),
                'attributes' => $this->attributeBuilder->createAttributeCollection($model->getAttributes()),
                'codeTacs' => $codeTacs,
                'formCodeTac' => $formCodeTac->createView(),
                'asideDetailsActive' => 'series',
                'asideDetailsActiveContextualLink' => [
                    'parent' => 'app_series_list',
                    'label' => $model->getSerie()->getName(),
                    'link' => $this->router->generate('app_models_list', ['serie' => $model->getSerie()->getUuid()]),
                ],
                'highlightedItem' => 'app_series_list',
            ],
        ));

        return $response;
    }
}
