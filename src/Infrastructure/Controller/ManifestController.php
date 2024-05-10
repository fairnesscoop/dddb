<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\Cache;
use Symfony\Component\Routing\Attribute\Route;

final readonly class ManifestController
{
    public function __construct(
        private \Twig\Environment $twig,
    ) {
    }

    #[Route('/public/site.webmanifest', name: 'app_webmanifest', methods: ['GET'])]
    #[Cache(public: true, maxage: 864000, mustRevalidate: true)]
    public function __invoke(): Response
    {
        return JsonResponse::fromJsonString($this->twig->render(
            name: 'manifest.json.twig',
        ));
    }
}
