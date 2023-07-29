<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Model\Attribute;

use App\Application\Battery\Command\AddBatteryReferenceCommand;
use App\Application\CommandBusInterface;
use App\Domain\Model\Model;
use App\Infrastructure\Form\Model\Attribute\AddBatteryReferenceFormType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

class AddBatteryReferenceController
{
    public function __construct(
        private \Twig\Environment $twig,
        private RouterInterface $router,
        private FormFactoryInterface $formFactory,
        private CommandBusInterface $commandBus,
    ) {
    }

    #[Route('/models/{model}/battery/add', name: 'app_attribute_battery_add', methods: ['GET', 'POST'])]
    public function __invoke(Request $request, Model $model): Response
    {
        $command = new AddBatteryReferenceCommand($model);

        $formBatteryReference = $this->formFactory->create(AddBatteryReferenceFormType::class, $command, [
            'action' => $this->router->generate('app_attribute_battery_add', ['model' => $model->getUuid()]),
        ]);

        $formBatteryReference->handleRequest($request);
        $response = new Response();

        if ($formBatteryReference->isSubmitted()) {
            if ($formBatteryReference->isValid()) {
                $this->commandBus->handle($command);

                return new RedirectResponse(
                    $this->router->generate('app_attribute_battery', ['model' => $model->getUuid()]),
                    Response::HTTP_SEE_OTHER,
                );
            }

            $response->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $response->setContent($this->twig->render('models/attributes/_batteryAdd.html.twig', [
            'model' => $model,
            'formBatteryReference' => $formBatteryReference->createView(),
        ]));

        return $response;
    }
}
