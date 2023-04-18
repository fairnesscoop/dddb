<?php

declare(strict_types=1);

namespace App\Tests\Integration\Infrastructure\Controller\User;

use App\Tests\Integration\Infrastructure\Controller\AbstractWebTestCase;

final class ListUsersControllerTest extends AbstractWebTestCase
{
    public function testList(): void
    {
        $client = $this->login();
        $crawler = $client->request('GET', '/users');

        $this->assertResponseStatusCodeSame(200);
        $this->assertSecurityHeaders();
    }
}
