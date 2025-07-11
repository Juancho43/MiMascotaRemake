<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250707201233 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animals ADD CONSTRAINT FK_966C69DD478E8802 FOREIGN KEY (journal_id) REFERENCES journals (id)');
        $this->addSql('ALTER TABLE entries ADD CONSTRAINT FK_2DF8B3C5478E8802 FOREIGN KEY (journal_id) REFERENCES journals (id)');
        $this->addSql('ALTER TABLE journals ADD CONSTRAINT FK_13A255C18E962C16 FOREIGN KEY (animal_id) REFERENCES animals (id)');
        $this->addSql('ALTER TABLE journals ADD CONSTRAINT FK_13A255C1A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animals DROP FOREIGN KEY FK_966C69DD478E8802');
        $this->addSql('ALTER TABLE journals DROP FOREIGN KEY FK_13A255C18E962C16');
        $this->addSql('ALTER TABLE journals DROP FOREIGN KEY FK_13A255C1A76ED395');
        $this->addSql('ALTER TABLE entries DROP FOREIGN KEY FK_2DF8B3C5478E8802');
    }
}
