<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20231203124556 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Rename model name column and set not null';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE model RENAME COLUMN name TO reference');
        $this->addSql('ALTER TABLE model ALTER COLUMN reference DROP NOT NULL');
        $this->addSql('ALTER TABLE model ADD android_code_name VARCHAR(50)');
        $this->addSql("UPDATE model SET android_code_name='' WHERE android_code_name IS NULL");
        $this->addSql('ALTER TABLE model ALTER android_code_name SET NOT NULL');
        $this->addSql('ALTER TABLE model ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $now = (new \DateTime('now', new \DateTimeZone('UTC')))->format('Y-m-d H:i:s');
        $this->addSql("UPDATE model SET updated_at='{$now}'");
        $this->addSql('ALTER TABLE model ALTER updated_at SET NOT NULL');
        $this->addSql('ALTER TABLE model ADD variant SMALLINT');
        $this->addSql('UPDATE model SET variant=0');
        $this->addSql('ALTER TABLE model ALTER variant SET NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE model DROP variant');
        $this->addSql('ALTER TABLE model DROP updated_at');
        $this->addSql('ALTER TABLE model DROP android_code_name');
        $this->addSql('ALTER TABLE model RENAME COLUMN reference TO name');
        $this->addSql("UPDATE model SET name=''");
        $this->addSql('ALTER TABLE model ALTER COLUMN name SET NOT NULL');
    }
}
