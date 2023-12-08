<?php

declare(strict_types=1);

namespace App\Application\Model\Query;

use App\Application\Attribute\Builder\MergedAttributesBuilder;
use App\Application\Model\View\ModelView;
use App\Domain\Model\Exception\ModelNotFoundException;
use App\Domain\Model\Repository\CodeTacRepositoryInterface;
use App\Domain\Model\Repository\ModelRepositoryInterface;

final class ModelQueryHandler
{
    public function __construct(
        private readonly ModelRepositoryInterface $modelRepository,
        private readonly MergedAttributesBuilder $mergedAttributeBuilder,
        private readonly CodeTacRepositoryInterface $codeTacRepository,
    ) {
    }

    public function __invoke(ModelQuery $query): ModelView
    {
        $modelEntity = $this->modelRepository->findModelByUuid($query->modelUuid);

        if (\is_null($modelEntity)) {
            throw new ModelNotFoundException(sprintf('Model #%s not found', $query->modelUuid));
        }

        $attributeCollection = $this->mergedAttributeBuilder->getMergedAttributes($modelEntity);
        $codeTacs = $this->codeTacRepository->findCodeTacs($modelEntity);

        return new ModelView(
            uuid: $modelEntity->getUuid(),
            androidCodeName: $modelEntity->getAndroidCodeName(),
            variant: $modelEntity->getVariant(),
            reference: $modelEntity->getReference(),
            attributes: $attributeCollection,
            codeTacs: $codeTacs,
        );
    }
}
