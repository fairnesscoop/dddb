<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

class DefaultController
{
    public function __construct(
        private readonly RouterInterface $router,
    ) {
    }

    #[Route('/', name: 'app_default', methods: ['GET'])]
    public function __invoke(Request $request): Response
    {
        $preferredSupportedLocale = 'en';
        $userPreferredLang = strtolower(substr($request->getPreferredLanguage() ?: $preferredSupportedLocale, 0, 2));
        if ($userPreferredLang === 'fr') {
            $preferredSupportedLocale = 'fr';
        }

        return new RedirectResponse($this->router->generate(
            'app_series_public_list',
            ['_locale' => $preferredSupportedLocale],
        ));
    }
}
