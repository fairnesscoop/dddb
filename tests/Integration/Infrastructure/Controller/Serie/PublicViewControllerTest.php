<?php

declare(strict_types=1);

namespace App\Tests\Integration\Infrastructure\Controller\Serie;

use App\Tests\Integration\Infrastructure\Controller\AbstractWebTestCase;

final class PublicViewControllerTest extends AbstractWebTestCase
{
    public function testList(): void
    {
        $client = static::createClient();
        $client->request('GET', '/en/public/device/Fairphone-Serie-4/12134585-b6c4-444b-8dc3-2a17a0693e5c');

        $this->assertResponseStatusCodeSame(200);
        $this->assertSelectorTextContains('h1', 'Fairphone');
        $this->assertSelectorTextContains('h1', 'Serie 4');
        $this->assertSelectorTextContains('h1', 'FP4');
        $this->assertSelectorTextContains('main', 'Memo example');
        $this->assertSelectorTextContains('main', 'Lineage 19');
        $this->assertSelectorTextContains('main', 'FP4-BATT-2012');
    }
}
