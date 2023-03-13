<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230313131657 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE capacite DROP FOREIGN KEY FK_A1E9ED3B2E4F4908');
        $this->addSql('DROP INDEX IDX_A1E9ED3B2E4F4908 ON capacite');
        $this->addSql('ALTER TABLE capacite DROP smartphone_id');
        $this->addSql('ALTER TABLE smartphone ADD capacite_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE smartphone ADD CONSTRAINT FK_26B07E2E7C79189D FOREIGN KEY (capacite_id) REFERENCES capacite (id)');
        $this->addSql('CREATE INDEX IDX_26B07E2E7C79189D ON smartphone (capacite_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE capacite ADD smartphone_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE capacite ADD CONSTRAINT FK_A1E9ED3B2E4F4908 FOREIGN KEY (smartphone_id) REFERENCES smartphone (id)');
        $this->addSql('CREATE INDEX IDX_A1E9ED3B2E4F4908 ON capacite (smartphone_id)');
        $this->addSql('ALTER TABLE smartphone DROP FOREIGN KEY FK_26B07E2E7C79189D');
        $this->addSql('DROP INDEX IDX_26B07E2E7C79189D ON smartphone');
        $this->addSql('ALTER TABLE smartphone DROP capacite_id');
    }
}
