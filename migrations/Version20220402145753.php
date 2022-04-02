<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220402145753 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE budgetmoinsdepense ADD budget_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE budgetmoinsdepense ADD CONSTRAINT FK_1456960036ABA6B8 FOREIGN KEY (budget_id) REFERENCES budget (id)');
        $this->addSql('CREATE INDEX IDX_1456960036ABA6B8 ON budgetmoinsdepense (budget_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE budgetmoinsdepense DROP FOREIGN KEY FK_1456960036ABA6B8');
        $this->addSql('DROP INDEX IDX_1456960036ABA6B8 ON budgetmoinsdepense');
        $this->addSql('ALTER TABLE budgetmoinsdepense DROP budget_id');
    }
}
