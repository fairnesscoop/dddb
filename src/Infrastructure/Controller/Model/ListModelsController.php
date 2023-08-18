<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Model;

use App\Application\Model\Query\ListModelsQuery;
use App\Application\QueryBusInterface;
use App\Domain\Model\Serie;
use App\Infrastructure\Controller\Pagination\Builder;
use App\Infrastructure\Controller\ResponseBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

final class ListModelsController
{
    public function __construct(
        private readonly \Twig\Environment $twig,
        private readonly QueryBusInterface $queryBus,
        private readonly ResponseBuilder $responseBuilder,
        private readonly Builder $paginationBuilder,
    ) {
    }

    #[Route('/series/{serie}/models', name: 'app_models_list', methods: ['GET'])]
    public function __invoke(Request $request, Serie $serie): Response
    {
        try {
            $pagination = $this->paginationBuilder->fromRequest($request);
        } catch (BadRequestHttpException $exception) {
            return $this->responseBuilder->badRequest($exception->getMessage());
        }

        /** @var Paginator $models */
        $models = $this->queryBus->handle(
            new ListModelsQuery(
                serie: $serie,
                page: $pagination->page,
                pageSize: $pagination->pageSize,
            ),
        );

        return new Response(
            content: $this->twig->render(
                name: 'models/list.html.twig',
                context: [
                    'serie' => $serie,
                    'models' => $models,
                    'page' => $pagination->page,
                    'pageSize' => $pagination->pageSize,
                    'asideDetailsActive' => 'series',
                    'highlightedItem' => 'app_series_list',
                ],
            ),
        );
    }
}
