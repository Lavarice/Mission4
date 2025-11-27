<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251127000000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create participant table with many-to-many relationship to tournoi';
    }

    public function up(Schema $schema): void
    {
        // Create participant table
        $this->addSql('CREATE TABLE participant (id INT AUTO_INCREMENT NOT NULL, prenom VARCHAR(50) NOT NULL, nom VARCHAR(50) NOT NULL, telephone VARCHAR(14) NOT NULL, email VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        // Create junction table for many-to-many relationship
        $this->addSql('CREATE TABLE participant_tournoi (participant_id INT NOT NULL, tournoi_id INT NOT NULL, INDEX IDX_9EB60E179D1C3019 (participant_id), INDEX IDX_9EB60E1733987749 (tournoi_id), PRIMARY KEY(participant_id, tournoi_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        // Add foreign key constraints
        $this->addSql('ALTER TABLE participant_tournoi ADD CONSTRAINT FK_9EB60E179D1C3019 FOREIGN KEY (participant_id) REFERENCES participant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE participant_tournoi ADD CONSTRAINT FK_9EB60E1733987749 FOREIGN KEY (tournoi_id) REFERENCES tournoi (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // Drop foreign keys and tables
        $this->addSql('ALTER TABLE participant_tournoi DROP FOREIGN KEY FK_9EB60E1733987749');
        $this->addSql('ALTER TABLE participant_tournoi DROP FOREIGN KEY FK_9EB60E179D1C3019');
        $this->addSql('DROP TABLE participant_tournoi');
        $this->addSql('DROP TABLE participant');
    }
}
