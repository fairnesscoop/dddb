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

    public function testPaginationRendering(): void
    {
        $client = $this->login();
        $page = $client->request('GET', '/users?page=2&pageSize=1');
        $this->assertResponseStatusCodeSame(200);
        $this->assertSecurityHeaders();

        $navLi = $page->filter('nav')->eq(1)->filter('li');
        $this->assertSame('Page précédente', $navLi->eq(0)->filter('span')->text());
        $this->assertSame('1', $navLi->eq(1)->filter('a')->text());
        $this->assertSame('2', $navLi->eq(2)->filter('a')->text());
        $this->assertSame('3', $navLi->eq(3)->filter('a')->text());
        $this->assertSame('Page suivante', $navLi->eq(4)->filter('span')->text());
    }

    public function testInvalidPageSize(): void
    {
        $client = $this->login();
        $client->request('GET', '/users?pageSize=0');
        $this->assertResponseStatusCodeSame(400);

        $client->request('GET', '/users?pageSize=-1');
        $this->assertResponseStatusCodeSame(400);

        $client->request('GET', '/users?pageSize=abc');
        $this->assertResponseStatusCodeSame(400);
    }

    public function testInvalidPageNumber(): void
    {
        $client = $this->login();
        $client->request('GET', '/users?page=0');
        $this->assertResponseStatusCodeSame(400);

        $client->request('GET', '/users?page=-1');
        $this->assertResponseStatusCodeSame(400);

        $client->request('GET', '/users?page=abc');
        $this->assertResponseStatusCodeSame(400);
    }

    public function testUnauthenticatedUser(): void
    {
        $client = static::createClient();
        $client->request('GET', '/users');

        $this->assertResponseRedirects('http://localhost/login', 302);
    }
}
