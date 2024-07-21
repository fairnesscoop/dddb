<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Repository\Model\Attribute\Denormalizer;

use App\Domain\Model\Attribute\AttributeInterface;
use App\Domain\Model\Attribute\SupportedOs;
use App\Domain\Model\Attribute\SupportedOsList;
use App\Domain\Os\OsVersionList;

class SupportedOsListDenormalizer implements DenormalizerInterface
{
    public function createAttribute(mixed $value): AttributeInterface
    {
        return new SupportedOsList($this->createList($value));
    }

    /**
     * @param array<array<string|int|null>> $internalValues
     *
     * @return iterable<SupportedOs>
     */
    private function createList(array $internalValues): iterable
    {
        static $osVersionList = new OsVersionList();

        return array_map(
            fn (array $internalValue) => new SupportedOs(
                $internalValue['id'],
                $osVersionList->getById($internalValue['osVersionId']),
                $internalValue['helpLink'],
                $internalValue['comment'],
                $internalValue['recoveryFileUrl'] ?? null,
                $internalValue['romFileUrl'] ?? null,
            ),
            $internalValues,
        );
    }

    public static function supports(): string
    {
        return SupportedOsList::NAME;
    }
}
