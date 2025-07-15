<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250713072821 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animals ADD createdAt DATETIME DEFAULT NULL, ADD updatedAt DATETIME DEFAULT NULL, ADD deletedAt DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE entries ADD createdAt DATETIME DEFAULT NULL, ADD updatedAt DATETIME DEFAULT NULL, ADD deletedAt DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE entry_images DROP FOREIGN KEY FK_DF2EA2D43DA5256D');
        $this->addSql('ALTER TABLE entry_images ADD CONSTRAINT FK_DF2EA2D43DA5256D FOREIGN KEY (image_id) REFERENCES images (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE images ADD createdAt DATETIME DEFAULT NULL, ADD updatedAt DATETIME DEFAULT NULL, ADD deletedAt DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE journals ADD createdAt DATETIME DEFAULT NULL, ADD updatedAt DATETIME DEFAULT NULL, ADD deletedAt DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD createdAt DATETIME DEFAULT NULL, ADD updatedAt DATETIME DEFAULT NULL, ADD deletedAt DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users DROP createdAt, DROP updatedAt, DROP deletedAt');
        $this->addSql('ALTER TABLE journals DROP createdAt, DROP updatedAt, DROP deletedAt');
        $this->addSql('ALTER TABLE animals DROP createdAt, DROP updatedAt, DROP deletedAt');
        $this->addSql('ALTER TABLE images DROP createdAt, DROP updatedAt, DROP deletedAt');
        $this->addSql('ALTER TABLE entry_images DROP FOREIGN KEY FK_DF2EA2D43DA5256D');
        $this->addSql('ALTER TABLE entry_images ADD CONSTRAINT FK_DF2EA2D43DA5256D FOREIGN KEY (image_id) REFERENCES images (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE entries DROP createdAt, DROP updatedAt, DROP deletedAt');
    }
}
