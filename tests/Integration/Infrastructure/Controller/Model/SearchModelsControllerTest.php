<?php

namespace App\Tests\Integration\Infrastructure\Controller\Model;

use App\Tests\Integration\Infrastructure\Controller\AbstractWebTestCase;

class SearchModelsControllerTest extends AbstractWebTestCase
{
    public function testTextSearch(): void
    {
        $client = $this->login();
        $crawler = $client->request('GET', '/en/search?search=fairphone+fp4');

        $this->assertResponseStatusCodeSame(200);
        $this->assertSame('fairphone fp4', $crawler->filter('h1')->text());

        $firstRow = $crawler->filter('tbody tr:first-child');
        $this->assertEquals('Fairphone', $firstRow->filter('td:first-child')->text());
        $this->assertEquals('Serie 4', $firstRow->filter('td:nth-child(2)')->text());
    }

    public function testTacSearch(): void
    {
        $client = $this->login();
        $crawler = $client->request('GET', '/en/search?search=35525509');

        $this->assertResponseStatusCodeSame(200);

        $firstRow = $crawler->filter('tbody tr:first-child');
        $this->assertEquals('Fairphone', $firstRow->filter('td:first-child')->text());
        $this->assertEquals('Serie 4', $firstRow->filter('td:nth-child(2)')->text());
    }

    public function testUnauthenticatedUser(): void
    {
        $client = static::createClient();
        $client->request('GET', '/en/search');

        $this->assertResponseRedirects('http://localhost/en/login', 302);
    }
}
