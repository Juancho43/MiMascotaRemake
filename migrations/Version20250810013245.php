<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250810013245 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal_images DROP FOREIGN KEY FK_5AEE7BB63DA5256D');
        $this->addSql('ALTER TABLE animal_images ADD CONSTRAINT FK_5AEE7BB63DA5256D FOREIGN KEY (image_id) REFERENCES images (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE animals CHANGE gender gender VARCHAR(12) NOT NULL, CHANGE color color VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE entries CHANGE date date DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\'');
        $this->addSql('ALTER TABLE journals DROP slug');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal_images DROP FOREIGN KEY FK_5AEE7BB63DA5256D');
        $this->addSql('ALTER TABLE animal_images ADD CONSTRAINT FK_5AEE7BB63DA5256D FOREIGN KEY (image_id) REFERENCES images (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE animals CHANGE color color VARCHAR(10) NOT NULL, CHANGE gender gender VARCHAR(6) NOT NULL');
        $this->addSql('ALTER TABLE entries CHANGE date date DATE NOT NULL');
        $this->addSql('ALTER TABLE journals ADD slug VARCHAR(150) NOT NULL');
    }
}
