<?php

declare(strict_types=1);

namespace App\Tests\Integration\Infrastructure\Controller\Manufacturer;

use App\Tests\Integration\Infrastructure\Controller\AbstractWebTestCase;

final class ListManufacturersControllerTest extends AbstractWebTestCase
{
    public function testList(): void
    {
        $client = $this->login();
        $crawler = $client->request('GET', '/en/manufacturers');

        $this->assertResponseStatusCodeSame(200);
        $this->assertSecurityHeaders();
        $this->assertSame('Manufacturers list', $crawler->filter('h1')->text());

        $this->assertSelectorTextContains('tbody tr td', 'Fairphone');
    }

    public function testUnauthenticatedUser(): void
    {
        $client = static::createClient();
        $client->request('GET', '/en/manufacturers');

        $this->assertResponseRedirects('http://localhost/en/login', 302);
    }
}
