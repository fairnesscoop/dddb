<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Model\Attribute;

use App\Application\Attribute\Builder\AttributeGenericBuilder;
use App\Domain\Model\Attribute\Memo;
use App\Domain\Model\Model;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MemoController
{
    public function __construct(
        private \Twig\Environment $twig,
        private AttributeGenericBuilder $attributeBuilder,
    ) {
    }

    #[Route('/models/{model}/memo', name: 'app_attribute_memo', methods: ['GET'])]
    public function __invoke(Model $model): Response
    {
        $attributeCollection = $this->attributeBuilder->createAttributeCollection($model->getAttributes());

        return new Response($this->twig->render('models/attributes/_memo.html.twig', [
            'model' => $model,
            'attribute' => $attributeCollection->has(Memo::NAME) ? $attributeCollection->get(Memo::NAME) : null,
        ]));
    }
}
