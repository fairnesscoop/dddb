<?php

declare(strict_types=1);

namespace App\Tests\Integration\Infrastructure\Controller\Serie;

use App\Tests\Integration\Infrastructure\Controller\AbstractWebTestCase;

final class PublicListControllerTest extends AbstractWebTestCase
{
    public function testList(): void
    {
        $client = static::createClient();
        $client->request('GET', '/en');

        $this->assertResponseStatusCodeSame(200);
        $this->assertSelectorTextContains('h1', 'DDDB');
        $this->assertSelectorTextContains('h2', 'Fairphone');
        $this->assertSelectorTextContains('main', 'Serie 4');
        // Serie 3 has no registered model, it should not be displayed
        $this->assertSelectorTextNotContains('main', 'Serie 3');
    }
}
