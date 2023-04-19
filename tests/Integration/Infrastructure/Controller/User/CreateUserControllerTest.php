<?php

declare(strict_types=1);

namespace App\Tests\Integration\Infrastructure\Controller\User;

use App\Tests\Integration\Infrastructure\Controller\AbstractWebTestCase;

final class CreateUserControllerTest extends AbstractWebTestCase
{
    public function testSuccessfullUserCreation(): void
    {
        $client = $this->login();
        $crawler = $client->request('GET', '/users/create');

        $this->assertResponseStatusCodeSame(200);
        $this->assertSecurityHeaders();
        $this->assertSame('Créer un utilisateur', $crawler->filter('h1')->text());

        $saveButton = $crawler->selectButton("Créer l'utilisateur");
        $form = $saveButton->form();
        $form["create_form[firstName]"] = "Benoit";
        $form["create_form[lastName]"] = "Paquier";
        $form["create_form[email]"] = "benoit@fairness.coop";
        $form["create_form[password][first]"] = "temptemp";
        $form["create_form[password][second]"] = "temptemp";
        $form["create_form[role]"] = "0";
        $client->submit($form);

        $this->assertResponseStatusCodeSame(303);
    }

    public function testEmailAlreadyExists(): void
    {
        $client = $this->login();
        $crawler = $client->request('GET', '/users/create');

        $this->assertResponseStatusCodeSame(200);
        $this->assertSecurityHeaders();
        $this->assertSame('Créer un utilisateur', $crawler->filter('h1')->text());

        $saveButton = $crawler->selectButton("Créer l'utilisateur");
        $form = $saveButton->form();
        $form["create_form[firstName]"] = "Benoit";
        $form["create_form[lastName]"] = "Paquier";
        $form["create_form[email]"] = "benoit.paquier@fairness.coop";
        $form["create_form[password][first]"] = "temptemp";
        $form["create_form[password][second]"] = "temptemp";
        $form["create_form[role]"] = "0";
        $client->submit($form);

        $this->assertResponseStatusCodeSame(422);
    }

    public function testBadValues(): void
    {
        $client = $this->login();
        $crawler = $client->request('GET', '/users/create');

        $saveButton = $crawler->selectButton("Créer l'utilisateur");
        $form = $saveButton->form();
        $form["create_form[firstName]"] = str_repeat('a', 101);
        $form["create_form[lastName]"] = str_repeat('b', 101);
        $form["create_form[email]"] = "benoit";
        $form["create_form[password][first]"] = "temptemp";
        $form["create_form[password][second]"] = "temptemptemp";
        $form["create_form[role]"] = "0";
        $crawler = $client->submit($form);

        $this->assertResponseStatusCodeSame(422);
        $this->assertSame("Cette chaîne est trop longue. Elle doit avoir au maximum 100 caractères.", $crawler->filter('#create_form_firstName_error')->text());
        $this->assertSame("Cette chaîne est trop longue. Elle doit avoir au maximum 100 caractères.", $crawler->filter('#create_form_lastName_error')->text());
        $this->assertSame("Cette valeur n'est pas une adresse email valide.", $crawler->filter('#create_form_email_error')->text());
        $this->assertSame("Les mots de passe ne sont pas identiques.", $crawler->filter('#create_form_password_first_error')->text());
    }

    public function testEmptyValues(): void
    {
        $client = $this->login();
        $crawler = $client->request('GET', '/users/create');

        $saveButton = $crawler->selectButton("Créer l'utilisateur");
        $form = $saveButton->form();
        $crawler = $client->submit($form);

        $this->assertResponseStatusCodeSame(422);
        $this->assertSame("Cette valeur ne doit pas être vide.", $crawler->filter('#create_form_lastName_error')->text());
        $this->assertSame("Cette valeur ne doit pas être vide.", $crawler->filter('#create_form_firstName_error')->text());
        $this->assertSame("Cette valeur ne doit pas être vide.", $crawler->filter('#create_form_email_error')->text());
        $this->assertSame("Cette valeur ne doit pas être vide.", $crawler->filter('#create_form_password_first_error')->text());
    }
}
