<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Model;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchModelsController
{
    public function __construct(
        private readonly \Twig\Environment $twig,
        private readonly SearchFromRequest $search,
    ) {
    }

    #[Route('/search', name: 'app_search', methods: ['GET'])]
    public function __invoke(Request $request): Response
    {
        $result = $this->search->searchModels($request);

        return new Response(
            content: $this->twig->render(
                name: 'models/search.html.twig',
                context: [
                    'search' => $result->searchQuery,
                    'models' => $result->models,
                    'asideDetailsActive' => 'models',
                ],
            ),
        );
    }
}
