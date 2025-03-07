<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250307162829 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Activate fuzzy search extensions';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE EXTENSION pg_trgm');
        $this->addSql('CREATE EXTENSION fuzzystrmatch');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP EXTENSION pg_trgm');
        $this->addSql('DROP EXTENSION fuzzystrmatch');
    }
}
