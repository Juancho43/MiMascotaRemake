<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250707193038 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE images ADD mimeType VARCHAR(50) NOT NULL, ADD imageable_type VARCHAR(100) NOT NULL, ADD imageable_id INT NOT NULL');
        $this->addSql('CREATE INDEX idx_imageable ON images (imageable_type, imageable_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX idx_imageable ON images');
        $this->addSql('ALTER TABLE images DROP mimeType, DROP imageable_type, DROP imageable_id');
    }
}
