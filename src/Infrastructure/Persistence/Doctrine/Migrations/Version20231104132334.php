<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20231104132334 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Change model parent relation type';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('DROP INDEX uniq_d79572d91ba4e67a');
        $this->addSql('CREATE INDEX IDX_D79572D91BA4E67A ON model (parent_model)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP INDEX IDX_D79572D91BA4E67A');
        $this->addSql('CREATE UNIQUE INDEX uniq_d79572d91ba4e67a ON model (parent_model)');
    }
}
