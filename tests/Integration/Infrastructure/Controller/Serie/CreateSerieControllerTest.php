<?php

declare(strict_types=1);

namespace App\Tests\Integration\Infrastructure\Controller\Serie;

use App\Tests\Integration\Infrastructure\Controller\AbstractWebTestCase;

final class CreateSerieControllerTest extends AbstractWebTestCase
{
    public function testSuccessfullSerieCreation(): void
    {
        $client = $this->login();
        $crawler = $client->request('GET', '/en/series/create');

        $this->assertResponseStatusCodeSame(200);
        $this->assertSecurityHeaders();
        $this->assertSame('Create serie', $crawler->filter('h1')->text());

        $saveButton = $crawler->selectButton('Create serie');
        $form = $saveButton->form();
        $form['create_form[name]'] = 'Model 3';
        $form['create_form[manufacturer]'] = '46918802-8e1c-4959-a201-bda5e41141b8';
        $client->submit($form);

        $this->assertResponseStatusCodeSame(303);
    }

    public function testNameAlreadyExists(): void
    {
        $client = $this->login();
        $crawler = $client->request('GET', '/en/series/create');

        $saveButton = $crawler->selectButton('Create serie');
        $form = $saveButton->form();
        $form["create_form[name]"] = "serie 4";
        $form['create_form[manufacturer]'] = '46918802-8e1c-4959-a201-bda5e41141b8';
        $client->submit($form);

        $this->assertResponseStatusCodeSame(422);
    }

    public function testBadValues(): void
    {
        $client = $this->login();
        $crawler = $client->request('GET', '/en/series/create');

        $saveButton = $crawler->selectButton('Create serie');
        $form = $saveButton->form();
        $form["create_form[name]"] = str_repeat('a', 101);
        $form['create_form[manufacturer]'] = '46918802-8e1c-4959-a201-bda5e41141b8';
        $crawler = $client->submit($form);

        $this->assertResponseStatusCodeSame(422);
        $this->assertSelectorTextContains('#create_form_name_error', 'This value is too long');
    }

    public function testEmptyValues(): void
    {
        $client = $this->login();
        $crawler = $client->request('GET', '/en/series/create');

        $saveButton = $crawler->selectButton('Create serie');
        $form = $saveButton->form();
        $crawler = $client->submit($form);

        $this->assertResponseStatusCodeSame(422);
        $this->assertSelectorTextContains('#create_form_name_error', 'This value should not be blank');
    }
}
