<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use Symfony\Component\HttpFoundation\Response;

class ResponseBuilder
{
    public function badRequest($message): Response
    {
        return new Response(
            $message,
            Response::HTTP_BAD_REQUEST,
        );
    }
}
