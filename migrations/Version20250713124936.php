<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250713124936 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_1483A5E9E7927C74 ON users');
        $this->addSql('ALTER TABLE users ADD value VARCHAR(100) DEFAULT NULL, ADD code VARCHAR(6) NOT NULL, ADD is_verified TINYINT(1) NOT NULL, DROP email');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E91D775834 ON users (value)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_1483A5E91D775834 ON users');
        $this->addSql('ALTER TABLE users ADD email VARCHAR(255) NOT NULL, DROP value, DROP code, DROP is_verified');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9E7927C74 ON users (email)');
    }
}
