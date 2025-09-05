<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250904010522 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reports (id VARCHAR(36) NOT NULL, reported_post_id VARCHAR(36) NOT NULL, reporter_user_id VARCHAR(36) NOT NULL, status VARCHAR(20) NOT NULL, reason VARCHAR(250) NOT NULL, createdAt DATETIME DEFAULT NULL, updatedAt DATETIME DEFAULT NULL, INDEX IDX_F11FA745EC0086D7 (reported_post_id), INDEX IDX_F11FA745DF3D6D95 (reporter_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reports ADD CONSTRAINT FK_F11FA745EC0086D7 FOREIGN KEY (reported_post_id) REFERENCES posts (id)');
        $this->addSql('ALTER TABLE reports ADD CONSTRAINT FK_F11FA745DF3D6D95 FOREIGN KEY (reporter_user_id) REFERENCES users (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reports DROP FOREIGN KEY FK_F11FA745EC0086D7');
        $this->addSql('ALTER TABLE reports DROP FOREIGN KEY FK_F11FA745DF3D6D95');
        $this->addSql('DROP TABLE reports');
    }
}
