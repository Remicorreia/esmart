<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230313203002 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE capacite (id INT AUTO_INCREMENT NOT NULL, smartphone_id INT DEFAULT NULL, valeur VARCHAR(255) NOT NULL, INDEX IDX_A1E9ED3B2E4F4908 (smartphone_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE capacite ADD CONSTRAINT FK_A1E9ED3B2E4F4908 FOREIGN KEY (smartphone_id) REFERENCES smartphone (id)');
        $this->addSql('ALTER TABLE smartphone DROP stock, DROP annee, DROP autonomie, DROP pouces');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE capacite DROP FOREIGN KEY FK_A1E9ED3B2E4F4908');
        $this->addSql('DROP TABLE capacite');
        $this->addSql('ALTER TABLE smartphone ADD stock INT NOT NULL, ADD annee INT NOT NULL, ADD autonomie INT NOT NULL, ADD pouces NUMERIC(10, 1) NOT NULL');
    }
}
