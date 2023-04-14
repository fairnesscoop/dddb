<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230413091346 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add root user';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('INSERT INTO "user" ("uuid", "first_name", "last_name", "email", "password", "role") '
            . "VALUES ('da4e1171-a7ea-42b9-ba64-9d54e492ac1d','Vertige','Admin','vertige@fairness.dev','\$2y\$13\$FREJHT6HkMat/970OKm2SOZNzvhR2VIYlmVb6I6XmdqLk0hMV3OYS','admin')");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DELETE FROM user WHERE uuid='da4e1171-a7ea-42b9-ba64-9d54e492ac1d'");
    }
}
