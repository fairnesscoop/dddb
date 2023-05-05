<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230428095250 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Rename Constructor to Manufacturer';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE serie DROP CONSTRAINT fk_aa3a933470644b5');
        $this->addSql('CREATE TABLE manufacturer (uuid UUID NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE UNIQUE INDEX manufacturer_name ON manufacturer (name)');
        $this->addSql('DROP TABLE constructor');
        $this->addSql('DROP INDEX idx_aa3a933470644b5');
        $this->addSql('ALTER TABLE serie RENAME COLUMN constructor_uuid TO manufacturer_uuid');
        $this->addSql('ALTER TABLE serie ADD CONSTRAINT FK_AA3A933454346169 FOREIGN KEY (manufacturer_uuid) REFERENCES manufacturer (uuid) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_AA3A933454346169 ON serie (manufacturer_uuid)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE serie DROP CONSTRAINT FK_AA3A933454346169');
        $this->addSql('CREATE TABLE constructor (uuid UUID NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE UNIQUE INDEX constructor_name ON constructor (name)');
        $this->addSql('DROP TABLE manufacturer');
        $this->addSql('DROP INDEX IDX_AA3A933454346169');
        $this->addSql('ALTER TABLE serie RENAME COLUMN manufacturer_uuid TO constructor_uuid');
        $this->addSql('ALTER TABLE serie ADD CONSTRAINT fk_aa3a933470644b5 FOREIGN KEY (constructor_uuid) REFERENCES constructor (uuid) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_aa3a933470644b5 ON serie (constructor_uuid)');
    }
}
