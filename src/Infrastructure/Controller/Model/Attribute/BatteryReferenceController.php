<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Model\Attribute;

use App\Domain\Model\Attribute\AttributeRepositoryInterface;
use App\Domain\Model\Attribute\Battery;
use App\Domain\Model\Model;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BatteryReferenceController
{
    public function __construct(
        private \Twig\Environment $twig,
        private AttributeRepositoryInterface $attributeRepository,
    ) {
    }

    #[Route('/models/{model}/battery', name: 'app_attribute_battery', methods: ['GET'])]
    public function __invoke(Model $model): Response
    {
        $attributeCollection = $this->attributeRepository->getModelAttributes($model);

        return new Response($this->twig->render('models/attributes/_battery.html.twig', [
            'model' => $model,
            'attribute' => $attributeCollection->get(Battery::NAME),
        ]));
    }
}
