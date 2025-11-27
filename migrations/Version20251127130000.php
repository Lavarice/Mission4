<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251127130000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Rename columns to snake_case for consistency';
    }

    public function up(Schema $schema): void
    {
        // Rename columns in genre table
        $this->addSql('ALTER TABLE genre CHANGE lib_genre lib_genre VARCHAR(255) NOT NULL');

        // Rename columns in plateformes table
        $this->addSql('ALTER TABLE plateformes CHANGE lib_plateforme lib_plateforme VARCHAR(255) NOT NULL');

        // Rename columns in marque table
        $this->addSql('ALTER TABLE marque CHANGE nom_marque nom_marque VARCHAR(255) NOT NULL');

        // Rename columns in pegi table
        $this->addSql('ALTER TABLE pegi CHANGE age_limite age_limite INT NOT NULL');
        $this->addSql('ALTER TABLE pegi CHANGE desc_pegi desc_pegi VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // Reverse changes (no actual changes needed as names are already correct)
    }
}
