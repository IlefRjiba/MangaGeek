<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241114151550 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mangatheque ADD COLUMN name VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__mangatheque AS SELECT id, member_id, description, publiee FROM mangatheque');
        $this->addSql('DROP TABLE mangatheque');
        $this->addSql('CREATE TABLE mangatheque (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, member_id INTEGER DEFAULT NULL, description VARCHAR(255) NOT NULL, publiee BOOLEAN NOT NULL, CONSTRAINT FK_A206DF317597D3FE FOREIGN KEY (member_id) REFERENCES member (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO mangatheque (id, member_id, description, publiee) SELECT id, member_id, description, publiee FROM __temp__mangatheque');
        $this->addSql('DROP TABLE __temp__mangatheque');
        $this->addSql('CREATE INDEX IDX_A206DF317597D3FE ON mangatheque (member_id)');
    }
}
