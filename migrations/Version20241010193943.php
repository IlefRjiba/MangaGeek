<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241010193943 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__manga AS SELECT id, name, author FROM manga');
        $this->addSql('DROP TABLE manga');
        $this->addSql('CREATE TABLE manga (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, mangashelf_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL, author VARCHAR(255) NOT NULL, CONSTRAINT FK_765A9E0396EDCFBC FOREIGN KEY (mangashelf_id) REFERENCES mangashelf (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO manga (id, name, author) SELECT id, name, author FROM __temp__manga');
        $this->addSql('DROP TABLE __temp__manga');
        $this->addSql('CREATE INDEX IDX_765A9E0396EDCFBC ON manga (mangashelf_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__manga AS SELECT id, name, author FROM manga');
        $this->addSql('DROP TABLE manga');
        $this->addSql('CREATE TABLE manga (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, author VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO manga (id, name, author) SELECT id, name, author FROM __temp__manga');
        $this->addSql('DROP TABLE __temp__manga');
    }
}
