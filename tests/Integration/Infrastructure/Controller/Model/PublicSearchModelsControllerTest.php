<?php

declare(strict_types=1);

namespace App\Tests\Integration\Infrastructure\Controller\Model;

use App\Tests\Integration\Infrastructure\Controller\AbstractWebTestCase;

final class PublicSearchModelsControllerTest extends AbstractWebTestCase
{
    public function testList(): void
    {
        $client = static::createClient();
        $client->request('GET', '/en/public/search?search=fairphone+4');

        $this->assertResponseStatusCodeSame(200);
        $this->assertSelectorTextContains('main', 'Fairphone Serie 4');
    }
}
