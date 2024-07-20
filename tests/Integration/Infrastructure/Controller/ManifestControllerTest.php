<?php

declare(strict_types=1);

namespace App\Tests\Integration\Infrastructure\Controller;

use App\Tests\Integration\Infrastructure\Controller\AbstractWebTestCase;

final class ManifestControllerTest extends AbstractWebTestCase
{
    public function testManifestFr(): void
    {
        $client = static::createClient();
        $client->request('GET', '/fr/public/site.webmanifest');

        $this->assertResponseIsSuccessful();

        $response = json_decode($client->getResponse()->getContent(), associative: true);
        self::assertEquals("Base de données d'appareils numériques", $response['name']);
    }
}
