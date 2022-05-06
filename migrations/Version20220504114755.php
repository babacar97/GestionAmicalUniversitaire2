<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220504114755 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE budget (id INT AUTO_INCREMENT NOT NULL, montant INT NOT NULL, date DATE NOT NULL, nom_budget VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE budgetmoinsdepense (id INT AUTO_INCREMENT NOT NULL, depense_id INT DEFAULT NULL, budget_id INT DEFAULT NULL, restant_budget INT NOT NULL, INDEX IDX_1456960041D81563 (depense_id), INDEX IDX_1456960036ABA6B8 (budget_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE depense (id INT AUTO_INCREMENT NOT NULL, budget_id INT DEFAULT NULL, type VARCHAR(255) NOT NULL, montant INT NOT NULL, date DATE NOT NULL, auteur VARCHAR(255) NOT NULL, commentaires VARCHAR(255) NOT NULL, justificatif VARCHAR(255) NOT NULL, INDEX IDX_3405975736ABA6B8 (budget_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, numero_telephone VARCHAR(255) NOT NULL, date_naissance DATE NOT NULL, lieu_naissance VARCHAR(255) NOT NULL, numero_carte_identite VARCHAR(255) NOT NULL, numero_carte_etudiant VARCHAR(255) NOT NULL, faculte VARCHAR(255) NOT NULL, niveau_etude VARCHAR(255) NOT NULL, codification VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE budgetmoinsdepense ADD CONSTRAINT FK_1456960041D81563 FOREIGN KEY (depense_id) REFERENCES depense (id)');
        $this->addSql('ALTER TABLE budgetmoinsdepense ADD CONSTRAINT FK_1456960036ABA6B8 FOREIGN KEY (budget_id) REFERENCES budget (id)');
        $this->addSql('ALTER TABLE depense ADD CONSTRAINT FK_3405975736ABA6B8 FOREIGN KEY (budget_id) REFERENCES budget (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE budgetmoinsdepense DROP FOREIGN KEY FK_1456960036ABA6B8');
        $this->addSql('ALTER TABLE depense DROP FOREIGN KEY FK_3405975736ABA6B8');
        $this->addSql('ALTER TABLE budgetmoinsdepense DROP FOREIGN KEY FK_1456960041D81563');
        $this->addSql('DROP TABLE budget');
        $this->addSql('DROP TABLE budgetmoinsdepense');
        $this->addSql('DROP TABLE depense');
        $this->addSql('DROP TABLE `user`');
    }
}
