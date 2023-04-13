<?php

declare(strict_types=1);

namespace App\Tests\Integration\Infrastructure\Controller\User;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class CreateUserControllerTest extends WebTestCase
{
    public function testSuccessfullUserCreation(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/users/create');

        $this->assertResponseStatusCodeSame(200);
        $this->assertSame('Créer un utilisateur', $crawler->filter('h1')->text());

        $saveButton = $crawler->selectButton("Créer l'utilisateur");
        $form = $saveButton->form();
        $form["create_form[firstName]"] = "Benoit";
        $form["create_form[lastName]"] = "Paquier";
        $form["create_form[email]"] = "benoit.paquier@fairness.coop";
        $form["create_form[password][first]"] = "temptemp";
        $form["create_form[password][second]"] = "temptemp";
        $form["create_form[role]"] = "contributor";
        $client->submit($form);

        $this->assertResponseStatusCodeSame(303);
    }

    public function testBadValues(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/users/create');

        $saveButton = $crawler->selectButton("Créer l'utilisateur");
        $form = $saveButton->form();
        $form["create_form[firstName]"] = str_repeat('a', 101);
        $form["create_form[lastName]"] = str_repeat('b', 101);
        $form["create_form[email]"] = "benoit.paquier@fairness.coop";
        $form["create_form[password][first]"] = "temptemp";
        $form["create_form[password][second]"] = "temptemp";
        $form["create_form[role]"] = "contributor";
        $client->submit($form);

        $this->assertResponseStatusCodeSame(422);
        $this->assertSame("Cette chaîne est trop longue. Elle doit avoir au maximum 100 caractères.", $crawler->filter('#create_form_firstName_error')->text());
        $this->assertSame("Cette chaîne est trop longue. Elle doit avoir au maximum 100 caractères.", $crawler->filter('#create_form_lastName_error')->text());
    }
}
