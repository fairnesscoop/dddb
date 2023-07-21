<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230701144331 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Refactor code tac in separate entity';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE code_tac (code INT NOT NULL, model_uuid UUID NOT NULL, PRIMARY KEY(code))');
        $this->addSql('CREATE INDEX IDX_ECC44430FC287C41 ON code_tac (model_uuid)');
        $this->addSql('ALTER TABLE code_tac ADD CONSTRAINT FK_ECC44430FC287C41 FOREIGN KEY (model_uuid) REFERENCES model (uuid) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE model DROP code_tac');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE code_tac DROP CONSTRAINT FK_ECC44430FC287C41');
        $this->addSql('DROP TABLE code_tac');
        $this->addSql('ALTER TABLE model ADD code_tac TEXT NOT NULL');
        $this->addSql('COMMENT ON COLUMN model.code_tac IS \'(DC2Type:array)\'');
    }
}
