<?php

namespace App\Tests\Integration\Infrastructure\Controller\Model;

use App\Tests\Integration\Infrastructure\Controller\AbstractWebTestCase;

class ListModelsControllerTest extends AbstractWebTestCase
{
    public function testListAll(): void
    {
        $client = $this->login();
        $crawler = $client->request('GET', '/en/series/12134585-b6c4-444b-8dc3-2a17a0693e5c/models');

        $this->assertResponseStatusCodeSame(200);
        $this->assertSecurityHeaders();
        $this->assertSame('Models list for Fairphone Serie 4', $crawler->filter('h1')->text());

        $firstRow = $crawler->filter('tbody tr:first-child');
        $this->assertEquals('FP4', $firstRow->filter('td:first-child')->text());
        $this->assertEquals('android-fp4', $firstRow->filter('td:nth-child(2)')->text());
        $this->assertEmpty($firstRow->filter('td:nth-child(3)')->text());
    }

    public function testUnauthenticatedUser(): void
    {
        $client = static::createClient();
        $client->request('GET', '/en/series/12134585-b6c4-444b-8dc3-2a17a0693e5c/models');

        $this->assertResponseRedirects('http://localhost/en/login', 302);
    }
}
