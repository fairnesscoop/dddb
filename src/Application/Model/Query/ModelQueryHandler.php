<?php

declare(strict_types=1);

namespace App\Application\Model\Query;

use App\Application\Model\View\ModelView;
use App\Domain\Model\Attribute\AttributeRepositoryInterface;
use App\Domain\Model\Exception\ModelNotFoundException;
use App\Domain\Model\Repository\CodeTacRepositoryInterface;
use App\Domain\Model\Repository\ModelRepositoryInterface;

final class ModelQueryHandler
{
    public function __construct(
        private readonly ModelRepositoryInterface $modelRepository,
        private readonly AttributeRepositoryInterface $attributeRepository,
        private readonly CodeTacRepositoryInterface $codeTacRepository,
    ) {
    }

    public function __invoke(ModelQuery $query): ModelView
    {
        $modelEntity = $this->modelRepository->findModelByUuid($query->modelUuid);

        if (\is_null($modelEntity)) {
            throw new ModelNotFoundException(sprintf('Model #%s not found', $query->modelUuid));
        }

        $attributeCollection = $this->attributeRepository->getModelAttributes($modelEntity);
        $codeTacs = $this->codeTacRepository->findCodeTacs($modelEntity);

        return new ModelView(
            uuid: $modelEntity->getUuid(),
            codeName: $modelEntity->getCodeName(),
            attributes: $attributeCollection,
            codeTacs: $codeTacs,
        );
    }
}
