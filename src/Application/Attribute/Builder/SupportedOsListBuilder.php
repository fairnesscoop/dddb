<?php

declare(strict_types=1);

namespace App\Application\Attribute\Builder;

use App\Domain\Model\Attribute\AttributeInterface;
use App\Domain\Model\Attribute\SupportedOs;
use App\Domain\Model\Attribute\SupportedOsList;
use App\Domain\Os\OsVersionList;

class SupportedOsListBuilder implements BuilderInterface
{
    public function createAttribute(mixed $value): AttributeInterface
    {
        return new SupportedOsList($this->createList($value));
    }

    public static function supports(): string
    {
        return SupportedOsList::NAME;
    }

    private function createList(array $internalValues): iterable
    {
        static $osVersionList = new OsVersionList();

        return array_map(
            fn (array $internalValue) => new SupportedOs(
                $internalValue['id'],
                $osVersionList->getById($internalValue['osVersionId']),
                $internalValue['helpLink'],
                $internalValue['comment'],
            ),
            $internalValues,
        );
    }
}
