<?php

declare(strict_types=1);

namespace App\Domain\Model\Attribute;

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
