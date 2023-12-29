<?php

declare(strict_types=1);

namespace App\Domain\Model\Attribute;

use App\Domain\Os\OsVersionList;

class SupportedOsList extends BaseAttribute
{
    public const NAME = 'supportedOsList';

    /**
     * @param SupportedOs[] $supportedOsList
     */
    public function __construct(
        private iterable $supportedOsList,
    ) {
    }

    public function add(SupportedOs $supportedOs): void
    {
        $this->supportedOsList[] = $supportedOs;
    }

    public function hasEOs(): bool
    {
        foreach ($this->supportedOsList as $os) {
            if ($os->osVersion->getOs()->getId() === OsVersionList::E_OS) {
                return true;
            }
        }

        return false;
    }

    public function deleteById(int $supportedOsId): void
    {
        $reducedList = [];
        foreach ($this->supportedOsList as $supportedOs) {
            if ($supportedOs->id !== $supportedOsId) {
                $reducedList[] = $supportedOs;
            }
        }

        $this->supportedOsList = $reducedList;
    }

    public function getValue(): mixed
    {
        return $this->supportedOsList;
    }
}
