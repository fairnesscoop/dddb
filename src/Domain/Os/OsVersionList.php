<?php

declare(strict_types=1);

namespace App\Domain\Os;

class OsVersionList implements \Iterator
{
    private readonly array $list;
    private int $index = 0;

    public function __construct()
    {
        $lineage = new Os(1, 'Lineage');
        $eOs = new Os(2, '/e/OS');

        $this->list = [
            new Version(1, '20', $lineage),
            new Version(2, '19', $lineage),
            new Version(3, '18', $lineage),
            new Version(4, '17', $lineage),
            new Version(5, '16', $lineage),
            new Version(6, '15', $lineage),
            new Version(7, '14', $lineage),
            new Version(8, 'S', $eOs),
            new Version(9, 'Q', $eOs),
            new Version(10, 'R', $eOs),
        ];
    }

    public function getById(int $osVersionId): Version
    {
        foreach ($this->list as $version) {
            if ($version->getId() === $osVersionId) {
                return $version;
            }
        }

        throw new \InvalidArgumentException(sprintf('Id #%d has no corresponding OS version', $osVersionId));
    }

    public function current(): Version
    {
        return $this->list[$this->index];
    }

    public function next(): void
    {
        ++$this->index;
    }

    public function key(): int
    {
        return $this->index;
    }

    public function valid(): bool
    {
        return $this->index < \count($this->list);
    }

    public function rewind(): void
    {
        $this->index = 0;
    }
}
