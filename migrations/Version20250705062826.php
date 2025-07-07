<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250705062826 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE animals (id VARCHAR(36) NOT NULL, journal_id VARCHAR(36) DEFAULT NULL, name VARCHAR(255) NOT NULL, breed VARCHAR(255) NOT NULL, gender VARCHAR(255) NOT NULL, age INT NOT NULL, UNIQUE INDEX UNIQ_966C69DD478E8802 (journal_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE animals ADD CONSTRAINT FK_966C69DD478E8802 FOREIGN KEY (journal_id) REFERENCES journals (id)');
        $this->addSql('ALTER TABLE journals ADD animal_id VARCHAR(36) DEFAULT NULL');
        $this->addSql('ALTER TABLE journals ADD CONSTRAINT FK_13A255C18E962C16 FOREIGN KEY (animal_id) REFERENCES animals (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_13A255C18E962C16 ON journals (animal_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE journals DROP FOREIGN KEY FK_13A255C18E962C16');
        $this->addSql('ALTER TABLE animals DROP FOREIGN KEY FK_966C69DD478E8802');
        $this->addSql('DROP TABLE animals');
        $this->addSql('DROP INDEX UNIQ_13A255C18E962C16 ON journals');
        $this->addSql('ALTER TABLE journals DROP animal_id');
    }
}
