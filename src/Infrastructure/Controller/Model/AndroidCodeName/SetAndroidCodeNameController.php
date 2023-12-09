<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Model\AndroidCodeName;

use App\Application\CommandBusInterface;
use App\Application\Model\Command\SetAndroidCodeNameCommand;
use App\Domain\Model\Model;
use App\Infrastructure\Form\Model\AndroidCodeName\SetAndroidCodeNameFormType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

class SetAndroidCodeNameController
{
    public function __construct(
        private \Twig\Environment $twig,
        private RouterInterface $router,
        private FormFactoryInterface $formFactory,
        private CommandBusInterface $commandBus,
    ) {
    }

    #[Route('/models/{model}/android-code-name/set', name: 'app_android_code_name_set', methods: ['GET', 'POST'])]
    public function __invoke(Request $request, Model $model): Response
    {
        $command = new SetAndroidCodeNameCommand($model, $model->getAndroidCodeName(), $model->getVariant());

        $formAndroidCodeName = $this->formFactory->create(SetAndroidCodeNameFormType::class, $command, [
            'action' => $this->router->generate('app_android_code_name_set', ['model' => $model->getUuid()]),
        ]);

        $formAndroidCodeName->handleRequest($request);
        $response = new Response();

        if ($formAndroidCodeName->isSubmitted()) {
            if ($formAndroidCodeName->isValid()) {
                $this->commandBus->handle($command);

                return new RedirectResponse(
                    $this->router->generate('app_android_code_name', ['model' => $model->getUuid()]),
                    Response::HTTP_SEE_OTHER,
                );
            }

            $response->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $response->setContent($this->twig->render('models/androidCodeName/_set.html.twig', [
            'model' => $model,
            'formAndroidCodeName' => $formAndroidCodeName->createView(),
        ]));

        return $response;
    }
}
