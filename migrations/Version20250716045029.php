<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250716045029 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_location (id VARCHAR(36) NOT NULL, user_id VARCHAR(36) DEFAULT NULL, location_id VARCHAR(36) DEFAULT NULL, UNIQUE INDEX UNIQ_BE136DCBA76ED395 (user_id), INDEX IDX_BE136DCB64D218E (location_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_location ADD CONSTRAINT FK_BE136DCBA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE user_location ADD CONSTRAINT FK_BE136DCB64D218E FOREIGN KEY (location_id) REFERENCES locations (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_location DROP FOREIGN KEY FK_BE136DCBA76ED395');
        $this->addSql('ALTER TABLE user_location DROP FOREIGN KEY FK_BE136DCB64D218E');
        $this->addSql('DROP TABLE user_location');
    }
}
