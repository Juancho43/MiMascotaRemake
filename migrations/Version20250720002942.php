<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250720002942 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE forums (id VARCHAR(36) NOT NULL, name VARCHAR(100) NOT NULL, slug VARCHAR(100) NOT NULL, description VARCHAR(200) NOT NULL, createdAt DATETIME DEFAULT NULL, updatedAt DATETIME DEFAULT NULL, deletedAt DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE posts (id VARCHAR(36) NOT NULL, forum_id VARCHAR(36) DEFAULT NULL, user_id VARCHAR(36) DEFAULT NULL, animal_id VARCHAR(36) DEFAULT NULL, location_id VARCHAR(36) DEFAULT NULL, title VARCHAR(100) NOT NULL, slug VARCHAR(100) NOT NULL, content VARCHAR(200) NOT NULL, createdAt DATETIME DEFAULT NULL, updatedAt DATETIME DEFAULT NULL, deletedAt DATETIME DEFAULT NULL, INDEX IDX_885DBAFA29CCBAD0 (forum_id), INDEX IDX_885DBAFAA76ED395 (user_id), INDEX IDX_885DBAFA8E962C16 (animal_id), INDEX IDX_885DBAFA64D218E (location_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE posts ADD CONSTRAINT FK_885DBAFA29CCBAD0 FOREIGN KEY (forum_id) REFERENCES forums (id)');
        $this->addSql('ALTER TABLE posts ADD CONSTRAINT FK_885DBAFAA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE posts ADD CONSTRAINT FK_885DBAFA8E962C16 FOREIGN KEY (animal_id) REFERENCES animals (id)');
        $this->addSql('ALTER TABLE posts ADD CONSTRAINT FK_885DBAFA64D218E FOREIGN KEY (location_id) REFERENCES locations (id)');
        $this->addSql('ALTER TABLE journals DROP FOREIGN KEY FK_13A255C18E962C16');
        $this->addSql('DROP INDEX UNIQ_13A255C18E962C16 ON journals');
        $this->addSql('ALTER TABLE journals ADD slug VARCHAR(150) NOT NULL, DROP animal_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE posts DROP FOREIGN KEY FK_885DBAFA29CCBAD0');
        $this->addSql('ALTER TABLE posts DROP FOREIGN KEY FK_885DBAFAA76ED395');
        $this->addSql('ALTER TABLE posts DROP FOREIGN KEY FK_885DBAFA8E962C16');
        $this->addSql('ALTER TABLE posts DROP FOREIGN KEY FK_885DBAFA64D218E');
        $this->addSql('DROP TABLE forums');
        $this->addSql('DROP TABLE posts');
        $this->addSql('ALTER TABLE journals ADD animal_id VARCHAR(36) DEFAULT NULL, DROP slug');
        $this->addSql('ALTER TABLE journals ADD CONSTRAINT FK_13A255C18E962C16 FOREIGN KEY (animal_id) REFERENCES animals (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_13A255C18E962C16 ON journals (animal_id)');
    }
}
