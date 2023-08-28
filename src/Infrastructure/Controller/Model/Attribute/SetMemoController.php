<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Model\Attribute;

use App\Application\CommandBusInterface;
use App\Application\Memo\Command\SetMemoCommand;
use App\Domain\Model\Attribute\AttributeRepositoryInterface;
use App\Domain\Model\Attribute\Memo;
use App\Domain\Model\Model;
use App\Infrastructure\Form\Model\Attribute\SetMemoFormType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

class SetMemoController
{
    public function __construct(
        private \Twig\Environment $twig,
        private RouterInterface $router,
        private FormFactoryInterface $formFactory,
        private CommandBusInterface $commandBus,
        private AttributeRepositoryInterface $attributeRepository,
    ) {
    }

    #[Route('/models/{model}/memo/set', name: 'app_attribute_memo_set', methods: ['GET', 'POST'])]
    public function __invoke(Request $request, Model $model): Response
    {
        $memo = $this->attributeRepository->createAttributeFromModel($model, Memo::NAME);
        $command = new SetMemoCommand($model, $memo?->getValue());

        $formMemo = $this->formFactory->create(SetMemoFormType::class, $command, [
            'action' => $this->router->generate('app_attribute_memo_set', ['model' => $model->getUuid()]),
        ]);

        $formMemo->handleRequest($request);
        $response = new Response();

        if ($formMemo->isSubmitted()) {
            if ($formMemo->isValid()) {
                $this->commandBus->handle($command);

                return new RedirectResponse(
                    $this->router->generate('app_attribute_memo', ['model' => $model->getUuid()]),
                    Response::HTTP_SEE_OTHER,
                );
            }

            $response->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $response->setContent($this->twig->render('models/attributes/_memoSet.html.twig', [
            'model' => $model,
            'formMemo' => $formMemo->createView(),
        ]));

        return $response;
    }
}
