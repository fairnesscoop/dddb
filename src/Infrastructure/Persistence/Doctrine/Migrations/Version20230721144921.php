<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230721144921 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Change attribute column to jsonb';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE model ALTER COLUMN attributes SET DATA TYPE jsonb');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE model ALTER COLUMN attributes SET DATA TYPE json');
    }
}
