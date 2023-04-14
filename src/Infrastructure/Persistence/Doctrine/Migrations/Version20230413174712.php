<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230413174712 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add mapped enum type';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('COMMENT ON COLUMN "user".role IS \'(DC2Type:role)\'');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('COMMENT ON COLUMN "user".role IS NULL');
    }
}
