<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230404160009 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE model (uuid UUID NOT NULL, serie_uuid UUID NOT NULL, name VARCHAR(50) NOT NULL, code_tac TEXT NOT NULL, attributes JSON NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE INDEX IDX_D79572D9A1A4494 ON model (serie_uuid)');
        $this->addSql('COMMENT ON COLUMN model.code_tac IS \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE model ADD CONSTRAINT FK_D79572D9A1A4494 FOREIGN KEY (serie_uuid) REFERENCES serie (uuid) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE model DROP CONSTRAINT FK_D79572D9A1A4494');
        $this->addSql('DROP TABLE model');
    }
}
