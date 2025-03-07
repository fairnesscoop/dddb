<?php

declare(strict_types=1);

namespace App\Domain;

final class Pagination
{
    /** @var array<mixed> */
    public readonly array $windowPages;
    public readonly int $lastPage;
    public readonly bool $hasFirstPageLandmark;
    public readonly bool $hasLeftTruncature;
    public readonly bool $hasRightTruncature;
    public readonly bool $hasLastPageLandmark;

    /**
     * @param iterable<mixed> $items
     */
    public function __construct(
        public readonly iterable $items,
        public readonly int $totalItems,
        int $page,
        int $pageSize,
    ) {
        $this->lastPage = $totalItems > 0 ? (int) ceil($totalItems / $pageSize) : 1;

        $numSiblings = 2;
        $firstPage = 1;
        $leftSibling = max($page - $numSiblings, $firstPage);
        $rightSibling = min($page + $numSiblings, $this->lastPage);

        $this->windowPages = range($leftSibling, $rightSibling);
        $this->hasLeftTruncature = $leftSibling >= $firstPage + 2;
        $this->hasRightTruncature = $rightSibling <= $this->lastPage - 2;

        $this->hasFirstPageLandmark = $leftSibling >= $firstPage + 1;
        $this->hasLastPageLandmark = $rightSibling <= $this->lastPage - 1;
    }
}
