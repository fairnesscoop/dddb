<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Serie;

use App\Application\QueryBusInterface;
use App\Application\Serie\Query\ListSeriesQuery;
use App\Infrastructure\Controller\Pagination\Builder;
use App\Infrastructure\Controller\ResponseBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

final class ListSeriesController
{
    public function __construct(
        private readonly \Twig\Environment $twig,
        private readonly QueryBusInterface $queryBus,
        private readonly ResponseBuilder $responseBuilder,
        private readonly Builder $paginationBuilder,
    ) {
    }

    #[Route('/series', name: 'app_series_list', methods: ['GET'])]
    public function __invoke(Request $request)
    {
        try {
            $pagination = $this->paginationBuilder->fromRequest($request);
        } catch (BadRequestHttpException $exception) {
            return $this->responseBuilder->badRequest($exception->getMessage());
        }

        $series = $this->queryBus->handle(
            new ListSeriesQuery(
                page: $pagination->page,
                pageSize: $pagination->pageSize,
                manufacturerUuid: $request->get('manufacturer'),
            ),
        );

        return new Response(
            content: $this->twig->render(
                name: 'series/list.html.twig',
                context: [
                    'series' => $series,
                    'page' => $pagination->page,
                    'pageSize' => $pagination->pageSize,
                    'asideDetailsActive' => 'series',
                ],
            ),
        );
    }
}
