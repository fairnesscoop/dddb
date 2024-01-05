<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Model;

use App\Application\Model\Query\SearchQuery;
use App\Application\QueryBusInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\FlashBagAwareSessionInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class SearchFromRequest
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
        private readonly TranslatorInterface $translator,
    ) {
    }

    public function searchModels(Request $request): SearchResultView
    {
        $search = $request->query->get('search');
        if (empty($search) || mb_strlen($search) > 30) {
            $session = $request->getSession();
            \assert($session instanceof FlashBagAwareSessionInterface, 'Session is not FlashBagAwareSessionInterface');
            $errorMsg = $this->translator->trans('models.search.form.codeTac.invalidQuery', [], 'validators');
            $session->getFlashBag()->add('error', $errorMsg);

            return new SearchResultView([], '');
        }

        return new SearchResultView(
            $this->queryBus->handle(new SearchQuery($search)),
            $search,
        );
    }
}
