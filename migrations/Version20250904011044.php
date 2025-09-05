<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250904011044 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contact_requests (id VARCHAR(36) NOT NULL, requester_id VARCHAR(36) NOT NULL, owner_id VARCHAR(36) NOT NULL, post_id VARCHAR(36) NOT NULL, status VARCHAR(20) NOT NULL, createdAt DATETIME DEFAULT NULL, updatedAt DATETIME DEFAULT NULL, INDEX IDX_E1A04AC6ED442CF4 (requester_id), INDEX IDX_E1A04AC67E3C61F9 (owner_id), INDEX IDX_E1A04AC64B89032C (post_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contact_requests ADD CONSTRAINT FK_E1A04AC6ED442CF4 FOREIGN KEY (requester_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE contact_requests ADD CONSTRAINT FK_E1A04AC67E3C61F9 FOREIGN KEY (owner_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE contact_requests ADD CONSTRAINT FK_E1A04AC64B89032C FOREIGN KEY (post_id) REFERENCES posts (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contact_requests DROP FOREIGN KEY FK_E1A04AC6ED442CF4');
        $this->addSql('ALTER TABLE contact_requests DROP FOREIGN KEY FK_E1A04AC67E3C61F9');
        $this->addSql('ALTER TABLE contact_requests DROP FOREIGN KEY FK_E1A04AC64B89032C');
        $this->addSql('DROP TABLE contact_requests');
    }
}
