<?php

declare(strict_types=1);

namespace App\Tests\Integration\Infrastructure\Controller\User;

use App\Domain\User\Enum\RoleEnum;
use App\Tests\Integration\Infrastructure\Controller\AbstractWebTestCase;

final class ListUsersControllerTest extends AbstractWebTestCase
{
    public function testList(): void
    {
        $client = $this->login();
        $crawler = $client->request('GET', '/users');

        $this->assertResponseStatusCodeSame(200);
        $this->assertSecurityHeaders();
        $this->assertSame('Liste des utilisateurs', $crawler->filter('h1')->text());
        $this->assertMetaTitle('Liste des utilisateurs - Référentiel Smartphones', $crawler);

        $rows = $crawler->filter('tbody > tr');
        $this->assertSame(3, $rows->count());

        $this->assertSame('Benoit', $rows->eq(0)->filter('td')->eq(0)->text());
        $this->assertSame('Paquier', $rows->eq(0)->filter('td')->eq(1)->text());
        $this->assertSame('benoit.paquier@fairness.coop', $rows->eq(0)->filter('td')->eq(2)->text());
        $this->assertSame(RoleEnum::ROLE_ADMIN->value, $rows->eq(0)->filter('td')->eq(3)->text());

        $this->assertSame('Gregory', $rows->eq(1)->filter('td')->eq(0)->text());
        $this->assertSame('Pelletier', $rows->eq(1)->filter('td')->eq(1)->text());
        $this->assertSame('gregory.pelletier@fairness.coop', $rows->eq(1)->filter('td')->eq(2)->text());
        $this->assertSame(RoleEnum::ROLE_ADMIN->value, $rows->eq(1)->filter('td')->eq(3)->text());

        $this->assertSame('Mathieu', $rows->eq(2)->filter('td')->eq(0)->text());
        $this->assertSame('Marchois', $rows->eq(2)->filter('td')->eq(1)->text());
        $this->assertSame('mathieu.marchois@fairness.coop', $rows->eq(2)->filter('td')->eq(2)->text());
        $this->assertSame(RoleEnum::ROLE_ADMIN->value, $rows->eq(2)->filter('td')->eq(3)->text());

        $createUserButton = $crawler->filter('header > a > button');
        $this->assertSame('Créer un utilisateur', $createUserButton->text());
    }

    public function testUnauthenticatedUser(): void
    {
        $client = static::createClient();
        $client->request('GET', '/users');

        $this->assertResponseRedirects('http://localhost/login', 302);
    }
}
