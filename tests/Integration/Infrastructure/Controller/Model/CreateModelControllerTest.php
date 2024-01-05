<?php

declare(strict_types=1);

namespace App\Tests\Integration\Infrastructure\Controller\Model;

use App\Domain\Model\Model;
use App\Tests\Integration\Infrastructure\Controller\AbstractWebTestCase;

final class CreateModelControllerTest extends AbstractWebTestCase
{
    public function testSuccessfullSerieCreation(): void
    {
        $client = $this->login();
        $crawler = $client->request('GET', '/en/series/12134585-b6c4-444b-8dc3-2a17a0693e5c/models/create');

        $this->assertResponseStatusCodeSame(200);
        $this->assertSecurityHeaders();
        $this->assertSame('Create model', $crawler->filter('h1')->text());

        $saveButton = $crawler->selectButton('Create model');
        $form = $saveButton->form();
        $form['create_form[reference]'] = 'FP4-2022';
        $form['create_form[androidCodeName]'] = 'android-fp4';
        $form['create_form[variant]'] = '1';
        $form['create_form[parentModel]'] = 'b4b0f83d-b70a-461d-a822-1f4451111efc';
        $client->submit($form);

        $this->assertResponseStatusCodeSame(303);

        $entityManager = $client->getContainer()->get('doctrine')->getManager();
        $repository = $entityManager->getRepository(Model::class);
        $insertedEntity = $repository->findOneBy(['reference' => 'FP4-2022']);
        $this->assertInstanceOf(Model::class, $insertedEntity);
        $this->assertEquals('android-fp4', $insertedEntity->getAndroidCodeName());
        $this->assertEquals('Serie 4', $insertedEntity->getSerie()->getName());
    }

    public function testReferenceAlreadyExists(): void
    {
        $client = $this->login();
        $crawler = $client->request('GET', '/en/series/12134585-b6c4-444b-8dc3-2a17a0693e5c/models/create');

        $saveButton = $crawler->selectButton('Create model');
        $form = $saveButton->form();
        $form['create_form[reference]'] = 'FP4';
        $form['create_form[androidCodeName]'] = 'android-fp4';
        $client->submit($form);

        $this->assertResponseStatusCodeSame(422);
    }

    public function testBadReferenceValue(): void
    {
        $client = $this->login();
        $crawler = $client->request('GET', '/en/series/12134585-b6c4-444b-8dc3-2a17a0693e5c/models/create');

        $saveButton = $crawler->selectButton('Create model');
        $form = $saveButton->form();
        $form['create_form[reference]'] = str_repeat('a', 101);
        $form['create_form[androidCodeName]'] = 'android-fp4';
        $crawler = $client->submit($form);

        $this->assertResponseStatusCodeSame(422);
        $this->assertSelectorTextContains('#create_form_reference_error', 'This value is too long');
    }

    public function testBadAndroidCodeNameValue(): void
    {
        $client = $this->login();
        $crawler = $client->request('GET', '/en/series/12134585-b6c4-444b-8dc3-2a17a0693e5c/models/create');

        $saveButton = $crawler->selectButton('Create model');
        $form = $saveButton->form();
        $form['create_form[androidCodeName]'] = str_repeat('a', 101);
        $crawler = $client->submit($form);

        $this->assertResponseStatusCodeSame(422);
        $this->assertSelectorTextContains('#create_form_androidCodeName_error', 'This value is too long');
    }

    public function testEmptyValues(): void
    {
        $client = $this->login();
        $crawler = $client->request('GET', '/en/series/12134585-b6c4-444b-8dc3-2a17a0693e5c/models/create');

        $saveButton = $crawler->selectButton('Create model');
        $form = $saveButton->form();
        $crawler = $client->submit($form);

        $this->assertResponseStatusCodeSame(422);
        $this->assertSelectorTextContains('#create_form_androidCodeName_error', 'This value should not be blank');
    }
}
