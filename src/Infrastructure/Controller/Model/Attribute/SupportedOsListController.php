<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Model\Attribute;

use App\Application\Attribute\Builder\AttributeGenericBuilder;
use App\Domain\Model\Attribute\SupportedOsList;
use App\Domain\Model\Model;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SupportedOsListController
{
    public function __construct(
        private \Twig\Environment $twig,
        private AttributeGenericBuilder $attributeBuilder,
    ) {
    }

    #[Route('/models/{model}/supported-os-list', name: 'app_attribute_supported_os_list', methods: ['GET'])]
    public function __invoke(Model $model): Response
    {
        $attributeCollection = $this->attributeBuilder->createAttributeCollection($model->getAttributes());

        return new Response($this->twig->render('models/attributes/_supportedOsList.html.twig', [
            'model' => $model,
            'attribute' => $attributeCollection->get(SupportedOsList::NAME),
        ]));
    }
}
