<?php

declare(strict_types=1);

namespace App\Tests\Integration\Infrastructure\Controller;

use App\Infrastructure\Persistence\Doctrine\Repository\User\UserRepository;
use App\Infrastructure\Security\SymfonyUser;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;

abstract class AbstractWebTestCase extends WebTestCase
{
    protected function login(string $email = 'benoit@email.org'): KernelBrowser
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail($email);

        $client->loginUser(
            new SymfonyUser(
                $testUser->getUuid(),
                $testUser->getEmail(),
                $testUser->getFullName(),
                $testUser->getPassword(),
                [$testUser->getRole()->value],
            )
        );

        return $client;
    }

    protected function assertMetaTitle(string $title, Crawler $crawler): void
    {
        self::assertEquals($title, $crawler->filter('title')->text());
    }

    protected function assertSecurityHeaders(): void
    {
        $this->assertResponseHeaderSame('X-Frame-Options', 'DENY');
        $this->assertResponseHeaderSame('X-Content-Type-Options', 'nosniff');
        $this->assertResponseHasHeader('X-Content-Security-Policy');
        $this->assertResponseHasHeader('Content-Security-Policy');
    }
}
