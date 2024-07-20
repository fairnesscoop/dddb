<?php

declare(strict_types=1);

namespace App\Tests\Unit\Infrastructure\Controller\Model;

use App\Application\Model\Query\SearchQuery;
use App\Application\Model\View\ModelHeader;
use App\Application\QueryBusInterface;
use App\Infrastructure\Controller\Model\SearchFromRequest;
use App\Infrastructure\Controller\Model\SearchResultView;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\FlashBagAwareSessionInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

final class SearchFromRequestTest extends TestCase
{
    private MockObject|QueryBusInterface $queryBus;
    private MockObject|TranslatorInterface $translator;
    private SearchFromRequest $searchFromRequest;

    public function setUp(): void
    {
        $this->queryBus = $this->createMock(QueryBusInterface::class);
        $this->translator = $this->createMock(TranslatorInterface::class);

        $this->searchFromRequest = new SearchFromRequest(
            $this->queryBus,
            $this->translator,
        );
    }

    public function testValidQuery(): void
    {
        $expectedModels = [
            new ModelHeader(
                'de22efa1-ac08-4133-a9fa-355f6b6c126d',
                null,
                'twolip',
                1,
            ),
        ];
        $this->queryBus->expects($this->once())
            ->method('handle')
            ->with(new SearchQuery('Fairphone 3'))
            ->willReturn($expectedModels);

        $request = new Request(['search' => 'Fairphone 3']);
        $result = $this->searchFromRequest->searchModels($request);

        self::assertEquals(new SearchResultView($expectedModels, 'Fairphone 3'), $result);
    }

    public function testEmptyQuery(): void
    {
        $this->queryBus->expects($this->never())->method('handle');

        $request = new Request(['search' => '']);
        $request->setSession($this->createSessionMock());
        $result = $this->searchFromRequest->searchModels($request);

        self::assertEquals(new SearchResultView([], ''), $result);
    }

    public function testNoQuery(): void
    {
        $this->queryBus->expects($this->never())->method('handle');

        $request = new Request();
        $request->setSession($this->createSessionMock());
        $result = $this->searchFromRequest->searchModels($request);

        self::assertEquals(new SearchResultView([], ''), $result);
    }

    public function testTooLongQuery(): void
    {
        $this->queryBus->expects($this->never())->method('handle');

        $request = new Request(['search' => str_pad('x', 32)]);
        $request->setSession($this->createSessionMock());
        $result = $this->searchFromRequest->searchModels($request);

        self::assertEquals(new SearchResultView([], ''), $result);
    }

    private function createSessionMock(): MockObject|FlashBagAwareSessionInterface
    {
        /** @var MockObject|FlashBagAwareSessionInterface $sessionMock */
        $sessionMock = $this->createMock(FlashBagAwareSessionInterface::class);
        $sessionMock->expects($this->once())
            ->method('getFlashBag')
            ->willReturn($this->createMock(FlashBagInterface::class));

        return $sessionMock;
    }
}
