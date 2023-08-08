<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Manufacturer;

use App\Application\Manufacturer\Query\ListManufacturersQuery;
use App\Application\QueryBusInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

final class ListManufacturersController
{
    public function __construct(
        private \Twig\Environment $twig,
        private QueryBusInterface $queryBus,
        private TranslatorInterface $translator,
    ) {
    }

    #[Route('/manufacturers', name: 'app_manufacturers_list', methods: ['GET'])]
    public function __invoke(Request $request)
    {
        $page = $request->query->getInt('page', 1);
        $pageSize = min($request->query->getInt('pageSize', 20), 100);

        if ($pageSize <= 0 || $page <= 0) {
            throw new BadRequestHttpException(
                $this->translator->trans('invalid.page_or_page_size', [], 'validators'),
            );
        }

        $manufacturers = $this->queryBus->handle(
            new ListManufacturersQuery(
                page: $page,
                pageSize: $pageSize,
            ),
        );

        return new Response(
            content: $this->twig->render(
                name: 'manufacturers/list.html.twig',
                context: [
                    'manufacturers' => $manufacturers,
                    'page' => $page,
                    'pageSize' => $pageSize,
                    'asideDetailsActive' => 'manufacturers',
                ],
            ),
        );
    }
}
