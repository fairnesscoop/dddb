<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Model;

use App\Application\Model\Query\SearchQuery;
use App\Application\QueryBusInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\FlashBagAwareSessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class SearchModelsController
{
    public function __construct(
        private readonly \Twig\Environment $twig,
        private readonly QueryBusInterface $queryBus,
        private readonly TranslatorInterface $translator,
    ) {
    }

    #[Route('/search', name: 'app_search', methods: ['GET'])]
    public function __invoke(Request $request): Response
    {
        $search = $request->query->get('search');
        if (mb_strlen($search) > 30 || empty($search)) {
            $session = $request->getSession();
            \assert($session instanceof FlashBagAwareSessionInterface, 'Session is not FlashBagAwareSessionInterface');
            $errorMsg = $this->translator->trans('models.search.form.codeTac.invalidQuery', [], 'validators');
            $session->getFlashBag()->add('error', $errorMsg);

            $models = [];
        } else {
            $models = $this->queryBus->handle(new SearchQuery($search));
        }

        return new Response(
            content: $this->twig->render(
                name: 'models/search.html.twig',
                context: [
                    'search' => $search,
                    'models' => $models,
                    'asideDetailsActive' => 'models',
                ],
            ),
        );
    }
}
