<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220311181543 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD nom VARCHAR(255) NOT NULL, ADD prenom VARCHAR(255) NOT NULL, ADD adresse VARCHAR(255) NOT NULL, ADD numero_telephone INT NOT NULL, ADD date_naissance DATE NOT NULL, ADD lieu_naissance VARCHAR(255) NOT NULL, ADD numero_carte_identite INT NOT NULL, ADD numero_carte_etudiant VARCHAR(255) NOT NULL, ADD faculte VARCHAR(255) NOT NULL, ADD niveau_etude VARCHAR(255) NOT NULL, ADD codification VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user` DROP nom, DROP prenom, DROP adresse, DROP numero_telephone, DROP date_naissance, DROP lieu_naissance, DROP numero_carte_identite, DROP numero_carte_etudiant, DROP faculte, DROP niveau_etude, DROP codification');
    }
}
