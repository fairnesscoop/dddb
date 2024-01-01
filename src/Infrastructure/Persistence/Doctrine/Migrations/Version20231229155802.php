<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20231229155802 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create term table for search engine';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE term (word VARCHAR(255) NOT NULL, model_uuid UUID NOT NULL, PRIMARY KEY(word, model_uuid))');
        $this->addSql('CREATE INDEX IDX_A50FE78DFC287C41 ON term (model_uuid)');
        $this->addSql('ALTER TABLE term ADD CONSTRAINT FK_A50FE78DFC287C41 FOREIGN KEY (model_uuid) REFERENCES model (uuid) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE term DROP CONSTRAINT FK_A50FE78DFC287C41');
        $this->addSql('DROP TABLE term');
    }
}
