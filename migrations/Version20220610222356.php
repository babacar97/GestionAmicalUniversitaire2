<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220610222356 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE actualite (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, datepublie DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE vote CHANGE id_user_id id_user_id INT NOT NULL, CHANGE date_vote date_vote DATE NOT NULL, CHANGE code_de_confirmation code_de_confirmation INT NOT NULL, CHANGE a_voter a_voter TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE actualite');
        $this->addSql('ALTER TABLE vote CHANGE id_user_id id_user_id INT DEFAULT NULL, CHANGE date_vote date_vote DATE DEFAULT NULL, CHANGE code_de_confirmation code_de_confirmation INT DEFAULT NULL, CHANGE a_voter a_voter TINYINT(1) DEFAULT NULL');
    }
}
