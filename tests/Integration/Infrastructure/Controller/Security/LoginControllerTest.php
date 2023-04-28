<?php

namespace App\Tests\Integration\Infrastructure\Controller\Security;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginControllerTest extends WebTestCase
{
    public function testLoginSuccess(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/en/login');

        $this->assertSelectorTextContains('h1', 'Sign in');

        $saveButton = $crawler->selectButton('Sign in');
        $form = $saveButton->form();
        $form['email'] = 'contrib@vertige.org';
        $form['password'] = 'test';
        $client->submit($form);

        $this->assertResponseStatusCodeSame(302);
        $client->followRedirect();
        $this->assertResponseStatusCodeSame(200);
    }

    public function testLoginFailed(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/en/login');

        $saveButton = $crawler->selectButton('Sign in');
        $form = $saveButton->form();
        $form['email'] = 'contrib@vertige.org';
        $form['password'] = 'incorrect_password';
        $client->submit($form);

        $crawler = $client->request('GET', '/en/users/create');
        $this->assertResponseRedirects('http://localhost/en/login');
    }

}
