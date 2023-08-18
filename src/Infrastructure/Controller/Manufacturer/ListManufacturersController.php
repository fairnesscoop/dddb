<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Manufacturer;

use App\Application\Manufacturer\Query\ListManufacturersQuery;
use App\Application\QueryBusInterface;
use App\Infrastructure\Controller\Pagination\Builder;
use App\Infrastructure\Controller\ResponseBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

final class ListManufacturersController
{
    public function __construct(
        private readonly \Twig\Environment $twig,
        private readonly QueryBusInterface $queryBus,
        private readonly ResponseBuilder $responseBuilder,
        private readonly Builder $paginationBuilder,
    ) {
    }

    #[Route('/manufacturers', name: 'app_manufacturers_list', methods: ['GET'])]
    public function __invoke(Request $request)
    {
        try {
            $pagination = $this->paginationBuilder->fromRequest($request);
        } catch (BadRequestHttpException $exception) {
            return $this->responseBuilder->badRequest($exception->getMessage());
        }

        $manufacturers = $this->queryBus->handle(
            new ListManufacturersQuery(
                page: $pagination->page,
                pageSize: $pagination->pageSize,
            ),
        );

        return new Response(
            content: $this->twig->render(
                name: 'manufacturers/list.html.twig',
                context: [
                    'manufacturers' => $manufacturers,
                    'page' => $pagination->page,
                    'pageSize' => $pagination->pageSize,
                    'asideDetailsActive' => 'manufacturers',
                ],
            ),
        );
    }
}
