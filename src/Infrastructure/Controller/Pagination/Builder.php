<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Pagination;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Contracts\Translation\TranslatorInterface;

class Builder
{
    public function __construct(
        private readonly TranslatorInterface $translator,
    ) {
    }

    public function fromRequest(Request $request): ParametersDto
    {
        if ($request->query->has('page')) {
            $page = $request->query->getInt('page');
        } else {
            $page = 1;
        }

        if ($request->query->has('pageSize')) {
            $pageSize = $request->query->getInt('pageSize');
        } else {
            $pageSize = 10;
        }

        if ($pageSize <= 0 || $page <= 0 || $pageSize > 100) {
            throw new BadRequestHttpException($this->translator->trans('invalid.page_or_page_size', [], 'validators'));
        }

        return new ParametersDto($page, $pageSize);
    }
}
