<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230404145556 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE "version" (uuid UUID NOT NULL, os_uuid UUID NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE INDEX IDX_BF1CD3C3275C4BBD ON "version" (os_uuid)');
        $this->addSql('ALTER TABLE "version" ADD CONSTRAINT FK_BF1CD3C3275C4BBD FOREIGN KEY (os_uuid) REFERENCES os (uuid) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "version" DROP CONSTRAINT FK_BF1CD3C3275C4BBD');
        $this->addSql('DROP TABLE "version"');
    }
}
