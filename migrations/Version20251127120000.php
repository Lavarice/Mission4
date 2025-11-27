<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251127120000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create jeu_video table with many-to-one relationships to genre, pegi, plateforme and marque';
    }

    public function up(Schema $schema): void
    {
        // Create jeu_video table
        $this->addSql('CREATE TABLE jeu_video (ref_jeu VARCHAR(50) NOT NULL, nom VARCHAR(100) NOT NULL, prix DOUBLE PRECISION NOT NULL, date_parution DATE NOT NULL, genre_id INT DEFAULT NULL, pegi_id INT DEFAULT NULL, plateforme_id INT DEFAULT NULL, marque_id INT DEFAULT NULL, INDEX IDX_5A4864C14296D193 (genre_id), INDEX IDX_5A4864C1B4EA2F74 (pegi_id), INDEX IDX_5A4864C15DC1AF33 (plateforme_id), INDEX IDX_5A4864C1ABF12ECD (marque_id), PRIMARY KEY(ref_jeu)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        // Add foreign key constraints
        $this->addSql('ALTER TABLE jeu_video ADD CONSTRAINT FK_5A4864C14296D193 FOREIGN KEY (genre_id) REFERENCES genre (id)');
        $this->addSql('ALTER TABLE jeu_video ADD CONSTRAINT FK_5A4864C1B4EA2F74 FOREIGN KEY (pegi_id) REFERENCES pegi (id)');
        $this->addSql('ALTER TABLE jeu_video ADD CONSTRAINT FK_5A4864C15DC1AF33 FOREIGN KEY (plateforme_id) REFERENCES plateformes (id)');
        $this->addSql('ALTER TABLE jeu_video ADD CONSTRAINT FK_5A4864C1ABF12ECD FOREIGN KEY (marque_id) REFERENCES marque (id)');
    }

    public function down(Schema $schema): void
    {
        // Drop foreign keys and table
        $this->addSql('ALTER TABLE jeu_video DROP FOREIGN KEY FK_5A4864C14296D193');
        $this->addSql('ALTER TABLE jeu_video DROP FOREIGN KEY FK_5A4864C1B4EA2F74');
        $this->addSql('ALTER TABLE jeu_video DROP FOREIGN KEY FK_5A4864C15DC1AF33');
        $this->addSql('ALTER TABLE jeu_video DROP FOREIGN KEY FK_5A4864C1ABF12ECD');
        $this->addSql('DROP TABLE jeu_video');
    }
}
