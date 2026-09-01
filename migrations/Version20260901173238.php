<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260901173238 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE campaign ADD created_by_id INT NOT NULL');
        $this->addSql('ALTER TABLE campaign ADD CONSTRAINT FK_1F1512DDB03A8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) NOT DEFERRABLE');
        $this->addSql('CREATE INDEX IDX_1F1512DDB03A8386 ON campaign (created_by_id)');
        $this->addSql('ALTER TABLE "user" ALTER tenant_id SET NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE campaign DROP CONSTRAINT FK_1F1512DDB03A8386');
        $this->addSql('DROP INDEX IDX_1F1512DDB03A8386');
        $this->addSql('ALTER TABLE campaign DROP created_by_id');
        $this->addSql('ALTER TABLE "user" ALTER tenant_id DROP NOT NULL');
    }
}
