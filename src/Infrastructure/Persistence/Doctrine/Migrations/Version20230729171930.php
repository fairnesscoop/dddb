<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230729171930 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Remove Os and Version tables';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE version DROP CONSTRAINT fk_bf1cd3c3275c4bbd');
        $this->addSql('DROP TABLE os');
        $this->addSql('DROP TABLE version');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE TABLE os (uuid UUID NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE UNIQUE INDEX os_name ON os (name)');
        $this->addSql('CREATE TABLE version (uuid UUID NOT NULL, os_uuid UUID NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE INDEX idx_bf1cd3c3275c4bbd ON version (os_uuid)');
        $this->addSql('ALTER TABLE version ADD CONSTRAINT fk_bf1cd3c3275c4bbd FOREIGN KEY (os_uuid) REFERENCES os (uuid) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
