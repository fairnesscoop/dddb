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
        $this->assertSame('Create user', $crawler->filter('h1')->text());

        $saveButton = $crawler->selectButton("Create user");
        $form = $saveButton->form();
        $form["form[firstName]"] = "Benoit";
        $form["form[lastName]"] = "Paquier";
        $form["form[email]"] = "benoit@fairness.coop";
        $form["form[password][first]"] = "temptemp";
        $form["form[password][second]"] = "temptemp";
        $form["form[role]"] = "0";
        $client->submit($form);

        $this->assertResponseStatusCodeSame(303);
    }

    public function testEmailAlreadyExists(): void
    {
        $client = $this->login();
        $crawler = $client->request('GET', '/users/create');

        $this->assertResponseStatusCodeSame(200);
        $this->assertSecurityHeaders();
        $this->assertSame('Create user', $crawler->filter('h1')->text());

        $saveButton = $crawler->selectButton("Create user");
        $form = $saveButton->form();
        $form["form[firstName]"] = "Benoit";
        $form["form[lastName]"] = "Paquier";
        $form["form[email]"] = "benoit@email.org";
        $form["form[password][first]"] = "temptemp";
        $form["form[password][second]"] = "temptemp";
        $form["form[role]"] = "0";
        $client->submit($form);

        $this->assertResponseStatusCodeSame(422);
    }

    public function testBadValues(): void
    {
        $client = $this->login();
        $crawler = $client->request('GET', '/users/create');

        $saveButton = $crawler->selectButton("Create user");
        $form = $saveButton->form();
        $form["form[firstName]"] = str_repeat('a', 101);
        $form["form[lastName]"] = str_repeat('b', 101);
        $form["form[email]"] = "benoit";
        $form["form[password][first]"] = "temptemp";
        $form["form[password][second]"] = "temptemptemp";
        $form["form[role]"] = "0";
        $crawler = $client->submit($form);

        $this->assertResponseStatusCodeSame(422);
        $this->assertSame("This value is too long. It should have 100 characters or less.", $crawler->filter('#form_firstName_error')->text());
        $this->assertSame("This value is too long. It should have 100 characters or less.", $crawler->filter('#form_lastName_error')->text());
        $this->assertSame("This value is not a valid email address.", $crawler->filter('#form_email_error')->text());
        $this->assertSame("Password and passowrd confirmation don't match.", $crawler->filter('#form_password_first_error')->text());
    }

    public function testEmptyValues(): void
    {
        $client = $this->login();
        $crawler = $client->request('GET', '/users/create');

        $saveButton = $crawler->selectButton("Create user");
        $form = $saveButton->form();
        $crawler = $client->submit($form);

        $this->assertResponseStatusCodeSame(422);
        $this->assertSame("This value should not be blank.", $crawler->filter('#form_lastName_error')->text());
        $this->assertSame("This value should not be blank.", $crawler->filter('#form_firstName_error')->text());
        $this->assertSame("This value should not be blank.", $crawler->filter('#form_email_error')->text());
        $this->assertSame("This value should not be blank.", $crawler->filter('#form_password_first_error')->text());
    }
}
