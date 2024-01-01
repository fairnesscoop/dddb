<?php

declare(strict_types=1);

namespace App\Tests\Integration\Infrastructure\Controller\Serie;

use App\Tests\Integration\Infrastructure\Controller\AbstractWebTestCase;

final class ListSeriesControllerTest extends AbstractWebTestCase
{
    public function testListAll(): void
    {
        $client = $this->login();
        $client->request('GET', '/en/series');

        $this->assertResponseStatusCodeSame(200);
        $this->assertSecurityHeaders();
        $this->assertSelectorTextSame('h1', 'Series list');

        $this->assertSelectorTextSame('tbody tr td', 'Fairphone');
        $this->assertSelectorTextContains('tbody tr td:nth-child(2)', 'Serie 3');
    }

    public function testListManufacturerSeries(): void
    {
        $client = $this->login();
        $crawler = $client->request('GET', '/en/series?manufacturer=46918802-8e1c-4959-a201-bda5e41141b8');

        $this->assertResponseStatusCodeSame(200);

        $this->assertSelectorTextSame('tbody tr td', 'Fairphone');
        $this->assertEquals(0, $crawler->filter('tbody tr td:contains("Google")')->count());
    }

    public function testUnauthenticatedUser(): void
    {
        $client = static::createClient();
        $client->request('GET', '/en/series');

        $this->assertResponseRedirects('http://localhost/en/login', 302);
    }
}
