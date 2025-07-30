<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250730122559 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE animal_images (id VARCHAR(36) NOT NULL, image_id VARCHAR(36) NOT NULL, animal_id VARCHAR(36) NOT NULL, position SMALLINT NOT NULL, UNIQUE INDEX UNIQ_5AEE7BB63DA5256D (image_id), INDEX IDX_5AEE7BB68E962C16 (animal_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE animals (id VARCHAR(36) NOT NULL, journal_id VARCHAR(36) DEFAULT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, color VARCHAR(10) NOT NULL, size VARCHAR(20) NOT NULL, breed VARCHAR(255) NOT NULL, gender VARCHAR(6) NOT NULL, birthdate DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', weight DOUBLE PRECISION NOT NULL, createdAt DATETIME DEFAULT NULL, updatedAt DATETIME DEFAULT NULL, deletedAt DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_966C69DD478E8802 (journal_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entries (id VARCHAR(36) NOT NULL, journal_id VARCHAR(36) NOT NULL, title VARCHAR(60) NOT NULL, content LONGTEXT NOT NULL, date DATE NOT NULL, createdAt DATETIME DEFAULT NULL, updatedAt DATETIME DEFAULT NULL, deletedAt DATETIME DEFAULT NULL, INDEX IDX_2DF8B3C5478E8802 (journal_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entry_images (id VARCHAR(36) NOT NULL, image_id VARCHAR(36) NOT NULL, entry_id VARCHAR(36) NOT NULL, position SMALLINT NOT NULL, UNIQUE INDEX UNIQ_DF2EA2D43DA5256D (image_id), INDEX IDX_DF2EA2D4BA364942 (entry_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE forums (id VARCHAR(36) NOT NULL, name VARCHAR(100) NOT NULL, slug VARCHAR(100) NOT NULL, description VARCHAR(200) NOT NULL, createdAt DATETIME DEFAULT NULL, updatedAt DATETIME DEFAULT NULL, deletedAt DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE images (id VARCHAR(36) NOT NULL, name VARCHAR(60) NOT NULL, path VARCHAR(255) NOT NULL, type VARCHAR(50) NOT NULL, size INT NOT NULL, imageable_type VARCHAR(100) NOT NULL, imageable_id VARCHAR(36) NOT NULL, createdAt DATETIME DEFAULT NULL, updatedAt DATETIME DEFAULT NULL, deletedAt DATETIME DEFAULT NULL, INDEX idx_imageable (imageable_type, imageable_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE journals (id VARCHAR(36) NOT NULL, user_id VARCHAR(36) DEFAULT NULL, slug VARCHAR(150) NOT NULL, createdAt DATETIME DEFAULT NULL, updatedAt DATETIME DEFAULT NULL, deletedAt DATETIME DEFAULT NULL, INDEX IDX_13A255C1A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE locations (id VARCHAR(36) NOT NULL, city VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, latitude VARCHAR(8) NOT NULL, longitude VARCHAR(8) NOT NULL, createdAt DATETIME DEFAULT NULL, updatedAt DATETIME DEFAULT NULL, deletedAt DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE posts (id VARCHAR(36) NOT NULL, forum_id VARCHAR(36) DEFAULT NULL, user_id VARCHAR(36) DEFAULT NULL, animal_id VARCHAR(36) DEFAULT NULL, location_id VARCHAR(36) DEFAULT NULL, title VARCHAR(100) NOT NULL, slug VARCHAR(100) NOT NULL, content VARCHAR(200) NOT NULL, createdAt DATETIME DEFAULT NULL, updatedAt DATETIME DEFAULT NULL, deletedAt DATETIME DEFAULT NULL, INDEX IDX_885DBAFA29CCBAD0 (forum_id), INDEX IDX_885DBAFAA76ED395 (user_id), INDEX IDX_885DBAFA8E962C16 (animal_id), INDEX IDX_885DBAFA64D218E (location_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_image (id VARCHAR(36) NOT NULL, user_id VARCHAR(36) DEFAULT NULL, image_id VARCHAR(36) NOT NULL, UNIQUE INDEX UNIQ_27FFFF07A76ED395 (user_id), UNIQUE INDEX UNIQ_27FFFF073DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_location (id VARCHAR(36) NOT NULL, user_id VARCHAR(36) DEFAULT NULL, location_id VARCHAR(36) DEFAULT NULL, UNIQUE INDEX UNIQ_BE136DCBA76ED395 (user_id), INDEX IDX_BE136DCB64D218E (location_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_preferences (id VARCHAR(36) NOT NULL, user_id VARCHAR(36) DEFAULT NULL, preference VARCHAR(255) NOT NULL, value VARCHAR(20) NOT NULL, INDEX IDX_402A6F60A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_tokens (id VARCHAR(36) NOT NULL, user_id VARCHAR(36) DEFAULT NULL, token VARCHAR(80) DEFAULT NULL, ipAddress VARCHAR(60) DEFAULT NULL, userAgent VARCHAR(255) DEFAULT NULL, createdAt DATETIME NOT NULL, expiresAt DATETIME DEFAULT NULL, INDEX IDX_CF080AB3A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id VARCHAR(36) NOT NULL, name VARCHAR(50) NOT NULL, telephone VARCHAR(25) NOT NULL, email VARCHAR(100) NOT NULL, code VARCHAR(6) NOT NULL, is_verified TINYINT(1) NOT NULL, password VARCHAR(255) NOT NULL, createdAt DATETIME DEFAULT NULL, updatedAt DATETIME DEFAULT NULL, deletedAt DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE animal_images ADD CONSTRAINT FK_5AEE7BB63DA5256D FOREIGN KEY (image_id) REFERENCES images (id)');
        $this->addSql('ALTER TABLE animal_images ADD CONSTRAINT FK_5AEE7BB68E962C16 FOREIGN KEY (animal_id) REFERENCES animals (id)');
        $this->addSql('ALTER TABLE animals ADD CONSTRAINT FK_966C69DD478E8802 FOREIGN KEY (journal_id) REFERENCES journals (id)');
        $this->addSql('ALTER TABLE entries ADD CONSTRAINT FK_2DF8B3C5478E8802 FOREIGN KEY (journal_id) REFERENCES journals (id)');
        $this->addSql('ALTER TABLE entry_images ADD CONSTRAINT FK_DF2EA2D43DA5256D FOREIGN KEY (image_id) REFERENCES images (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE entry_images ADD CONSTRAINT FK_DF2EA2D4BA364942 FOREIGN KEY (entry_id) REFERENCES entries (id)');
        $this->addSql('ALTER TABLE journals ADD CONSTRAINT FK_13A255C1A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE posts ADD CONSTRAINT FK_885DBAFA29CCBAD0 FOREIGN KEY (forum_id) REFERENCES forums (id)');
        $this->addSql('ALTER TABLE posts ADD CONSTRAINT FK_885DBAFAA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE posts ADD CONSTRAINT FK_885DBAFA8E962C16 FOREIGN KEY (animal_id) REFERENCES animals (id)');
        $this->addSql('ALTER TABLE posts ADD CONSTRAINT FK_885DBAFA64D218E FOREIGN KEY (location_id) REFERENCES locations (id)');
        $this->addSql('ALTER TABLE user_image ADD CONSTRAINT FK_27FFFF07A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE user_image ADD CONSTRAINT FK_27FFFF073DA5256D FOREIGN KEY (image_id) REFERENCES images (id)');
        $this->addSql('ALTER TABLE user_location ADD CONSTRAINT FK_BE136DCBA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE user_location ADD CONSTRAINT FK_BE136DCB64D218E FOREIGN KEY (location_id) REFERENCES locations (id)');
        $this->addSql('ALTER TABLE user_preferences ADD CONSTRAINT FK_402A6F60A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE user_tokens ADD CONSTRAINT FK_CF080AB3A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal_images DROP FOREIGN KEY FK_5AEE7BB63DA5256D');
        $this->addSql('ALTER TABLE animal_images DROP FOREIGN KEY FK_5AEE7BB68E962C16');
        $this->addSql('ALTER TABLE animals DROP FOREIGN KEY FK_966C69DD478E8802');
        $this->addSql('ALTER TABLE entries DROP FOREIGN KEY FK_2DF8B3C5478E8802');
        $this->addSql('ALTER TABLE entry_images DROP FOREIGN KEY FK_DF2EA2D43DA5256D');
        $this->addSql('ALTER TABLE entry_images DROP FOREIGN KEY FK_DF2EA2D4BA364942');
        $this->addSql('ALTER TABLE journals DROP FOREIGN KEY FK_13A255C1A76ED395');
        $this->addSql('ALTER TABLE posts DROP FOREIGN KEY FK_885DBAFA29CCBAD0');
        $this->addSql('ALTER TABLE posts DROP FOREIGN KEY FK_885DBAFAA76ED395');
        $this->addSql('ALTER TABLE posts DROP FOREIGN KEY FK_885DBAFA8E962C16');
        $this->addSql('ALTER TABLE posts DROP FOREIGN KEY FK_885DBAFA64D218E');
        $this->addSql('ALTER TABLE user_image DROP FOREIGN KEY FK_27FFFF07A76ED395');
        $this->addSql('ALTER TABLE user_image DROP FOREIGN KEY FK_27FFFF073DA5256D');
        $this->addSql('ALTER TABLE user_location DROP FOREIGN KEY FK_BE136DCBA76ED395');
        $this->addSql('ALTER TABLE user_location DROP FOREIGN KEY FK_BE136DCB64D218E');
        $this->addSql('ALTER TABLE user_preferences DROP FOREIGN KEY FK_402A6F60A76ED395');
        $this->addSql('ALTER TABLE user_tokens DROP FOREIGN KEY FK_CF080AB3A76ED395');
        $this->addSql('DROP TABLE animal_images');
        $this->addSql('DROP TABLE animals');
        $this->addSql('DROP TABLE entries');
        $this->addSql('DROP TABLE entry_images');
        $this->addSql('DROP TABLE forums');
        $this->addSql('DROP TABLE images');
        $this->addSql('DROP TABLE journals');
        $this->addSql('DROP TABLE locations');
        $this->addSql('DROP TABLE posts');
        $this->addSql('DROP TABLE user_image');
        $this->addSql('DROP TABLE user_location');
        $this->addSql('DROP TABLE user_preferences');
        $this->addSql('DROP TABLE user_tokens');
        $this->addSql('DROP TABLE users');
    }
}
