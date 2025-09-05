<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250824052617 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE forum_images (id VARCHAR(36) NOT NULL, forum_id VARCHAR(36) NOT NULL, image_id VARCHAR(36) NOT NULL, UNIQUE INDEX UNIQ_F8B08DBB29CCBAD0 (forum_id), UNIQUE INDEX UNIQ_F8B08DBB3DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE forum_images ADD CONSTRAINT FK_F8B08DBB29CCBAD0 FOREIGN KEY (forum_id) REFERENCES forums (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE forum_images ADD CONSTRAINT FK_F8B08DBB3DA5256D FOREIGN KEY (image_id) REFERENCES images (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE forum_images DROP FOREIGN KEY FK_F8B08DBB29CCBAD0');
        $this->addSql('ALTER TABLE forum_images DROP FOREIGN KEY FK_F8B08DBB3DA5256D');
        $this->addSql('DROP TABLE forum_images');
    }
}
