<?php

declare(strict_types=1);

namespace App\Tests\Integration\Infrastructure\Controller\Serie;

use App\Tests\Integration\Infrastructure\Controller\AbstractWebTestCase;

final class ListSeriesControllerTest extends AbstractWebTestCase
{
    public function testList(): void
    {
        $client = $this->login();
        $crawler = $client->request('GET', '/en/series');

        $this->assertResponseStatusCodeSame(200);
        $this->assertSecurityHeaders();
        $this->assertSelectorTextSame('h1', 'Series list');

        $this->assertSelectorTextSame('tbody tr td', 'Fairphone');
        $this->assertSelectorTextContains('tbody tr td:nth-child(2)', 'Serie 3');
    }

    public function testUnauthenticatedUser(): void
    {
        $client = static::createClient();
        $client->request('GET', '/en/series');

        $this->assertResponseRedirects('http://localhost/en/login', 302);
    }
}
