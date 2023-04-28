<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain;

use App\Domain\Pagination;
use PHPUnit\Framework\TestCase;

final class PaginationTest extends TestCase
{
    public function testWithNoItems(): void
    {
        $items = [];
        $page = 1;
        $pageSize = 10;

        $pagination = new Pagination(
            items: $items,
            totalItems: count($items),
            page: $page,
            pageSize: $pageSize
        );

        $this->assertSame($pagination->items, $items);
        $this->assertSame($pagination->totalItems, count($items));
        $this->assertSame($pagination->hasFirstPageLandmark, false);
        $this->assertSame($pagination->hasLeftTruncature, false);
        $this->assertSame($pagination->hasRightTruncature, false);
        $this->assertSame($pagination->hasLastPageLandmark, false);
        $this->assertSame($pagination->windowPages, [1]);
        $this->assertSame($pagination->lastPage, 1);
    }

    public function testWithOneItem(): void
    {
        $items = [[]];
        $page = 1;
        $pageSize = 10;

        $pagination = new Pagination(
            items: $items,
            totalItems: count($items),
            page: $page,
            pageSize: $pageSize
        );

        $this->assertSame($pagination->items, $items);
        $this->assertSame($pagination->totalItems, count($items));
        $this->assertSame($pagination->hasFirstPageLandmark, false);
        $this->assertSame($pagination->hasLeftTruncature, false);
        $this->assertSame($pagination->hasRightTruncature, false);
        $this->assertSame($pagination->hasLastPageLandmark, false);
        $this->assertSame($pagination->windowPages, [1]);
        $this->assertSame($pagination->lastPage, 1);
    }

    public function testWithTruncatures(): void
    {
        $items = [[], [], [], [], [], [], [], [], [], [], []];
        $page = 6;
        $pageSize = 1;

        $pagination = new Pagination(
            items: $items,
            totalItems: count($items),
            page: $page,
            pageSize: $pageSize
        );

        $this->assertSame($pagination->items, $items);
        $this->assertSame($pagination->totalItems, count($items));
        $this->assertSame($pagination->hasFirstPageLandmark, true);
        $this->assertSame($pagination->hasLeftTruncature, true);
        $this->assertSame($pagination->hasRightTruncature, true);
        $this->assertSame($pagination->hasLastPageLandmark, true);
        $this->assertSame($pagination->windowPages, [4, 5, 6, 7, 8]);
        $this->assertSame($pagination->lastPage, 11);
    }

    public function testWithoutTruncature(): void
    {
        $items = [[], [], [], [], [], [], [], [], [], [], []];
        $page = 1;
        $pageSize = 10;

        $pagination = new Pagination(
            items: $items,
            totalItems: count($items),
            page: $page,
            pageSize: $pageSize
        );

        $this->assertSame($pagination->items, $items);
        $this->assertSame($pagination->totalItems, count($items));
        $this->assertSame($pagination->hasFirstPageLandmark, false);
        $this->assertSame($pagination->hasLeftTruncature, false);
        $this->assertSame($pagination->hasRightTruncature, false);
        $this->assertSame($pagination->hasLastPageLandmark, false);
        $this->assertSame($pagination->windowPages, [1, 2]);
        $this->assertSame($pagination->lastPage, 2);
    }
}
