<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Model;

use App\Application\Model\Query\ListModelsQuery;
use App\Application\QueryBusInterface;
use App\Domain\Model\Serie;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

final class ListModelsController
{
    public function __construct(
        private \Twig\Environment $twig,
        private QueryBusInterface $queryBus,
        private TranslatorInterface $translator,
    ) {
    }

    #[Route('/series/{serie}/models', name: 'app_models_list', methods: ['GET'])]
    public function __invoke(Request $request, Serie $serie): Response
    {
        $page = $request->query->getInt('page', 1);
        $pageSize = min($request->query->getInt('pageSize', 20), 100);

        if ($pageSize <= 0 || $page <= 0) {
            throw new BadRequestHttpException(
                $this->translator->trans('invalid.page_or_page_size', [], 'validators'),
            );
        }

        /** @var Paginator $models */
        $models = $this->queryBus->handle(
            new ListModelsQuery(
                serie: $serie,
                page: $page,
                pageSize: $pageSize,
            ),
        );

        return new Response(
            content: $this->twig->render(
                name: 'models/list.html.twig',
                context: [
                    'serie' => $serie,
                    'models' => $models,
                    'page' => $page,
                    'pageSize' => $pageSize,
                    'asideDetailsActive' => 'series',
                    'highlightedItem' => 'app_series_list',
                ],
            ),
        );
    }
}
