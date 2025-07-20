<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250720061345 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_preferences DROP INDEX UNIQ_402A6F60A76ED395, ADD INDEX IDX_402A6F60A76ED395 (user_id)');
        $this->addSql('ALTER TABLE user_preferences ADD preference VARCHAR(255) NOT NULL, ADD value VARCHAR(20) NOT NULL, DROP preferences');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_preferences DROP INDEX IDX_402A6F60A76ED395, ADD UNIQUE INDEX UNIQ_402A6F60A76ED395 (user_id)');
        $this->addSql('ALTER TABLE user_preferences ADD preferences LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', DROP preference, DROP value');
    }
}
