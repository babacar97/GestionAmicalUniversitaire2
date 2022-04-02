<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220402134624 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE budget_moins_depense (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE budget_moins_depense_depense (budget_moins_depense_id INT NOT NULL, depense_id INT NOT NULL, INDEX IDX_FE4252987696A7DC (budget_moins_depense_id), INDEX IDX_FE42529841D81563 (depense_id), PRIMARY KEY(budget_moins_depense_id, depense_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE budget_moins_depense_budget (budget_moins_depense_id INT NOT NULL, budget_id INT NOT NULL, INDEX IDX_8EF5B28A7696A7DC (budget_moins_depense_id), INDEX IDX_8EF5B28A36ABA6B8 (budget_id), PRIMARY KEY(budget_moins_depense_id, budget_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE budget_moins_depense_depense ADD CONSTRAINT FK_FE4252987696A7DC FOREIGN KEY (budget_moins_depense_id) REFERENCES budget_moins_depense (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE budget_moins_depense_depense ADD CONSTRAINT FK_FE42529841D81563 FOREIGN KEY (depense_id) REFERENCES depense (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE budget_moins_depense_budget ADD CONSTRAINT FK_8EF5B28A7696A7DC FOREIGN KEY (budget_moins_depense_id) REFERENCES budget_moins_depense (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE budget_moins_depense_budget ADD CONSTRAINT FK_8EF5B28A36ABA6B8 FOREIGN KEY (budget_id) REFERENCES budget (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE budget_moins_depense_depense DROP FOREIGN KEY FK_FE4252987696A7DC');
        $this->addSql('ALTER TABLE budget_moins_depense_budget DROP FOREIGN KEY FK_8EF5B28A7696A7DC');
        $this->addSql('DROP TABLE budget_moins_depense');
        $this->addSql('DROP TABLE budget_moins_depense_depense');
        $this->addSql('DROP TABLE budget_moins_depense_budget');
    }
}
