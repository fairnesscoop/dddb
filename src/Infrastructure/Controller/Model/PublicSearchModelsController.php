<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Model;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PublicSearchModelsController
{
    public function __construct(
        private readonly \Twig\Environment $twig,
        private readonly SearchFromRequest $search,
    ) {
    }

    #[Route('/public/search', name: 'app_public_search', methods: ['GET'])]
    public function __invoke(Request $request): Response
    {
        $result = $this->search->searchModels($request);

        if ($request->headers->get('Turbo-Frame') === 'main') {
            $template = 'public/_search.html.twig';
        } else {
            $template = 'public/search.html.twig';
        }

        return new Response(
            content: $this->twig->render(
                name: $template,
                context: [
                    'search' => $result->searchQuery,
                    'models' => $result->models,
                ],
            ),
        );
    }
}
