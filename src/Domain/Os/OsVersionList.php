<?php

declare(strict_types=1);

namespace App\Domain\Os;

class OsVersionList implements \Iterator
{
    /** @var Version[] */
    private readonly array $list;
    private int $index = 0;

    private const LINEAGE = 1;
    public const E_OS = 2;

    public function __construct()
    {
        $lineage = new Os(self::LINEAGE, 'Lineage');
        $eOs = new Os(self::E_OS, '/e/OS');

        $this->list = [
            new Version(1, '20', $lineage),
            new Version(2, '19', $lineage),
            new Version(3, '18', $lineage),
            new Version(4, '17', $lineage),
            new Version(5, '16', $lineage),
            new Version(6, '15', $lineage),
            new Version(7, '14', $lineage),
            new Version(11, '13', $lineage),
            new Version(12, 'T', $eOs),
            new Version(8, 'S', $eOs),
            new Version(10, 'R', $eOs),
            new Version(9, 'Q', $eOs),
            new Version(13, 'Pie', $eOs),
            new Version(14, 'Oreo', $eOs),
            new Version(15, 'Nougat', $eOs),
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

    public function getLineageOsVersion(string $version): Version
    {
        foreach ($this->list as $osVersion) {
            if ($osVersion->getName() === $version && $osVersion->getOs()->getId() === self::LINEAGE) {
                return $osVersion;
            }
        }

        throw new \InvalidArgumentException("Version $version unsupported for Lineage OS");
    }

    public function getEOsVersion(string $version): Version
    {
        foreach ($this->list as $osVersion) {
            if ($osVersion->getName() === $version && $osVersion->getOs()->getId() === self::E_OS) {
                return $osVersion;
            }
        }

        throw new \InvalidArgumentException("Version $version unsupported for /e/OS");
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
