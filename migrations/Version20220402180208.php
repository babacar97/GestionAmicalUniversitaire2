<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220402180208 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE budget DROP FOREIGN KEY FK_73F2F77B41D81563');
        $this->addSql('DROP INDEX IDX_73F2F77B41D81563 ON budget');
        $this->addSql('ALTER TABLE budget DROP depense_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE budget ADD depense_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE budget ADD CONSTRAINT FK_73F2F77B41D81563 FOREIGN KEY (depense_id) REFERENCES depense (id)');
        $this->addSql('CREATE INDEX IDX_73F2F77B41D81563 ON budget (depense_id)');
    }
}
