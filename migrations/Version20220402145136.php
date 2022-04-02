<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220402145136 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE depense DROP FOREIGN KEY FK_34059757C3521C79');
        $this->addSql('DROP INDEX IDX_34059757C3521C79 ON depense');
        $this->addSql('ALTER TABLE depense DROP budgetmoinsdepense_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE depense ADD budgetmoinsdepense_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE depense ADD CONSTRAINT FK_34059757C3521C79 FOREIGN KEY (budgetmoinsdepense_id) REFERENCES budgetmoinsdepense (id)');
        $this->addSql('CREATE INDEX IDX_34059757C3521C79 ON depense (budgetmoinsdepense_id)');
    }
}
