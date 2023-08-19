<?php

declare(strict_types=1);

namespace App\Tests\Integration\Infrastructure\Controller;

use App\Tests\Integration\Infrastructure\Controller\AbstractWebTestCase;

final class DefaultControllerTest extends AbstractWebTestCase
{
    public function testRedirectFr(): void
    {
        $client = static::createClient();
        $client->request('GET', '/', server: ['HTTP_ACCEPT_LANGUAGE' => 'fr-FR;q=0.8,en-US;q=0.3']);

        $this->assertResponseRedirects('/fr');
    }

    public function testRedirectDe(): void
    {
        $client = static::createClient();
        $client->request('GET', '/', server: ['HTTP_ACCEPT_LANGUAGE' => 'de;q=0.8,en-US;q=0.3']);

        $this->assertResponseRedirects('/en');
    }
}
