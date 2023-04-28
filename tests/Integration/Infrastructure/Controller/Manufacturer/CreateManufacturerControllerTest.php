<?php

declare(strict_types=1);

namespace App\Tests\Integration\Infrastructure\Controller\Manufacturer;

use App\Tests\Integration\Infrastructure\Controller\AbstractWebTestCase;

final class CreateManufacturerControllerTest extends AbstractWebTestCase
{
    public function testSuccessfullUserCreation(): void
    {
        $client = $this->login();
        $crawler = $client->request('GET', '/en/manufacturers/create');

        $this->assertResponseStatusCodeSame(200);
        $this->assertSecurityHeaders();
        $this->assertSame('Create manufacturer', $crawler->filter('h1')->text());

        $saveButton = $crawler->selectButton('Create manufacturer');
        $form = $saveButton->form();
        $form["create_form[name]"] = "Nokia";
        $client->submit($form);

        $this->assertResponseStatusCodeSame(303);
    }

    public function testNameAlreadyExists(): void
    {
        $client = $this->login();
        $crawler = $client->request('GET', '/en/manufacturers/create');

        $this->assertResponseStatusCodeSame(200);
        $this->assertSecurityHeaders();
        $this->assertSame('Create manufacturer', $crawler->filter('h1')->text());

        $saveButton = $crawler->selectButton('Create manufacturer');
        $form = $saveButton->form();
        $form["create_form[name]"] = "Fairphone";
        $client->submit($form);

        $this->assertResponseStatusCodeSame(422);
    }

    public function testBadValues(): void
    {
        $client = $this->login();
        $crawler = $client->request('GET', '/en/manufacturers/create');

        $saveButton = $crawler->selectButton('Create manufacturer');
        $form = $saveButton->form();
        $form["create_form[name]"] = str_repeat('a', 101);
        $crawler = $client->submit($form);

        $this->assertResponseStatusCodeSame(422);
        $this->assertSelectorTextContains('#create_form_name_error', 'This value is too long');
    }

    public function testEmptyValues(): void
    {
        $client = $this->login();
        $crawler = $client->request('GET', '/en/manufacturers/create');

        $saveButton = $crawler->selectButton('Create manufacturer');
        $form = $saveButton->form();
        $crawler = $client->submit($form);

        $this->assertResponseStatusCodeSame(422);
        $this->assertSelectorTextContains('#create_form_name_error', 'This value should not be blank');
    }
}
