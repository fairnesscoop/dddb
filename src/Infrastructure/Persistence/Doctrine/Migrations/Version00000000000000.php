<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version00000000000000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Rollup migrations';
    }

    public function up(Schema $schema): void
    {
        if ($this->sm->tablesExist(['manufacturer'])) {
            $this->write('Delele all previous registered migrations');
            $this->addSql('DELETE FROM doctrine_migration_versions');

            return;
        }

        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\PostgreSQL120Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\PostgreSQL120Platform'.",
        );

        $this->addSql('CREATE TABLE battery (uuid UUID NOT NULL, reference VARCHAR(100) NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE UNIQUE INDEX battery_reference ON battery (reference)');
        $this->addSql('CREATE TABLE code_tac (code INT NOT NULL, model_uuid UUID NOT NULL, PRIMARY KEY(code))');
        $this->addSql('CREATE INDEX IDX_ECC44430FC287C41 ON code_tac (model_uuid)');
        $this->addSql('CREATE TABLE manufacturer (uuid UUID NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE UNIQUE INDEX manufacturer_name ON manufacturer (name)');
        $this->addSql('CREATE TABLE model (uuid UUID NOT NULL, serie_uuid UUID NOT NULL, parent_model UUID DEFAULT NULL, reference VARCHAR(50) DEFAULT NULL, android_code_name VARCHAR(50) NOT NULL, variant SMALLINT NOT NULL, attributes JSONB NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE INDEX IDX_D79572D9A1A4494 ON model (serie_uuid)');
        $this->addSql('CREATE INDEX IDX_D79572D91BA4E67A ON model (parent_model)');
        $this->addSql('CREATE TABLE serie (uuid UUID NOT NULL, manufacturer_uuid UUID NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE INDEX IDX_AA3A933454346169 ON serie (manufacturer_uuid)');
        $this->addSql('CREATE TABLE term (word VARCHAR(255) NOT NULL, model_uuid UUID NOT NULL, PRIMARY KEY(word, model_uuid))');
        $this->addSql('CREATE INDEX IDX_A50FE78DFC287C41 ON term (model_uuid)');
        $this->addSql('CREATE TABLE "user" (uuid UUID NOT NULL, first_name VARCHAR(100) NOT NULL, last_name VARCHAR(100) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, role VARCHAR(20) NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE UNIQUE INDEX user_email ON "user" (email)');
        $this->addSql('ALTER TABLE code_tac ADD CONSTRAINT FK_ECC44430FC287C41 FOREIGN KEY (model_uuid) REFERENCES model (uuid) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE model ADD CONSTRAINT FK_D79572D9A1A4494 FOREIGN KEY (serie_uuid) REFERENCES serie (uuid) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE model ADD CONSTRAINT FK_D79572D91BA4E67A FOREIGN KEY (parent_model) REFERENCES model (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE serie ADD CONSTRAINT FK_AA3A933454346169 FOREIGN KEY (manufacturer_uuid) REFERENCES manufacturer (uuid) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE term ADD CONSTRAINT FK_A50FE78DFC287C41 FOREIGN KEY (model_uuid) REFERENCES model (uuid) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\PostgreSQL120Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\PostgreSQL120Platform'.",
        );

        $this->addSql('ALTER TABLE code_tac DROP CONSTRAINT FK_ECC44430FC287C41');
        $this->addSql('ALTER TABLE model DROP CONSTRAINT FK_D79572D9A1A4494');
        $this->addSql('ALTER TABLE model DROP CONSTRAINT FK_D79572D91BA4E67A');
        $this->addSql('ALTER TABLE serie DROP CONSTRAINT FK_AA3A933454346169');
        $this->addSql('ALTER TABLE term DROP CONSTRAINT FK_A50FE78DFC287C41');
        $this->addSql('DROP TABLE battery');
        $this->addSql('DROP TABLE code_tac');
        $this->addSql('DROP TABLE manufacturer');
        $this->addSql('DROP TABLE model');
        $this->addSql('DROP TABLE serie');
        $this->addSql('DROP TABLE term');
        $this->addSql('DROP TABLE "user"');
    }
}
