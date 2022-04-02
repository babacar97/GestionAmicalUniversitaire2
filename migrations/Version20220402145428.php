<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220402145428 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE budgetmoinsdepense ADD depense_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE budgetmoinsdepense ADD CONSTRAINT FK_1456960041D81563 FOREIGN KEY (depense_id) REFERENCES depense (id)');
        $this->addSql('CREATE INDEX IDX_1456960041D81563 ON budgetmoinsdepense (depense_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE budgetmoinsdepense DROP FOREIGN KEY FK_1456960041D81563');
        $this->addSql('DROP INDEX IDX_1456960041D81563 ON budgetmoinsdepense');
        $this->addSql('ALTER TABLE budgetmoinsdepense DROP depense_id');
    }
}
