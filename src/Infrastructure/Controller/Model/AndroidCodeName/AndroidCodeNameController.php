<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller\Model\AndroidCodeName;

use App\Domain\Model\Model;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AndroidCodeNameController
{
    public function __construct(
        private \Twig\Environment $twig,
    ) {
    }

    #[Route('/models/{model}/android_code_name', name: 'app_android_code_name', methods: ['GET'])]
    public function __invoke(Model $model): Response
    {
        return new Response($this->twig->render('models/androidCodeName/_view.html.twig', [
            'model' => $model,
        ]));
    }
}
