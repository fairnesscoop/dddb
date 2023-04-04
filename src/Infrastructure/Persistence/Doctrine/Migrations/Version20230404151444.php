<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230404151444 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE serie (uuid UUID NOT NULL, constructor_uuid UUID NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE INDEX IDX_AA3A933470644B5 ON serie (constructor_uuid)');
        $this->addSql('ALTER TABLE serie ADD CONSTRAINT FK_AA3A933470644B5 FOREIGN KEY (constructor_uuid) REFERENCES constructor (uuid) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE serie DROP CONSTRAINT FK_AA3A933470644B5');
        $this->addSql('DROP TABLE serie');
    }
}
