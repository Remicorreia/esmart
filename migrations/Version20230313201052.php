<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230313201052 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE smartphone DROP FOREIGN KEY FK_26B07E2E7C79189D');
        $this->addSql('DROP TABLE capacite');
        $this->addSql('DROP INDEX IDX_26B07E2E7C79189D ON smartphone');
        $this->addSql('ALTER TABLE smartphone DROP capacite_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE capacite (id INT AUTO_INCREMENT NOT NULL, valeur INT NOT NULL, unite VARCHAR(10) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE smartphone ADD capacite_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE smartphone ADD CONSTRAINT FK_26B07E2E7C79189D FOREIGN KEY (capacite_id) REFERENCES capacite (id)');
        $this->addSql('CREATE INDEX IDX_26B07E2E7C79189D ON smartphone (capacite_id)');
    }
}
