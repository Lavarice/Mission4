<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20251126130000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create tournoi table with FK to plateformes';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE tournoi (id INT AUTO_INCREMENT NOT NULL, plateforme_id INT NOT NULL, nom VARCHAR(255) NOT NULL, date_debut DATETIME NOT NULL, date_fin DATETIME DEFAULT NULL, nb_participants INT DEFAULT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_7EC93D4B8F8F4E6F (plateforme_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tournoi ADD CONSTRAINT FK_7EC93D4B8F8F4E6F FOREIGN KEY (plateforme_id) REFERENCES plateformes (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE tournoi DROP FOREIGN KEY FK_7EC93D4B8F8F4E6F');
        $this->addSql('DROP TABLE tournoi');
    }
}
