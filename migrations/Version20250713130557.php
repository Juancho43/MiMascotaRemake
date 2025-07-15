<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250713130557 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_image DROP FOREIGN KEY FK_27FFFF07A76ED395');
        $this->addSql('DROP INDEX UNIQ_27FFFF07A76ED395 ON user_image');
        $this->addSql('ALTER TABLE user_image DROP user_id');
        $this->addSql('ALTER TABLE user_image ADD CONSTRAINT FK_27FFFF07BF396750 FOREIGN KEY (id) REFERENCES users (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_image DROP FOREIGN KEY FK_27FFFF07BF396750');
        $this->addSql('ALTER TABLE user_image ADD user_id VARCHAR(36) DEFAULT NULL');
        $this->addSql('ALTER TABLE user_image ADD CONSTRAINT FK_27FFFF07A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_27FFFF07A76ED395 ON user_image (user_id)');
    }
}
