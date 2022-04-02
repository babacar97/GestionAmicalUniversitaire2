<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220402143603 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE budgetmoinsdepense_depense (budgetmoinsdepense_id INT NOT NULL, depense_id INT NOT NULL, INDEX IDX_83E2EF84C3521C79 (budgetmoinsdepense_id), INDEX IDX_83E2EF8441D81563 (depense_id), PRIMARY KEY(budgetmoinsdepense_id, depense_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE budgetmoinsdepense_depense ADD CONSTRAINT FK_83E2EF84C3521C79 FOREIGN KEY (budgetmoinsdepense_id) REFERENCES budgetmoinsdepense (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE budgetmoinsdepense_depense ADD CONSTRAINT FK_83E2EF8441D81563 FOREIGN KEY (depense_id) REFERENCES depense (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE budgetmoinsdepense_depense');
    }
}
