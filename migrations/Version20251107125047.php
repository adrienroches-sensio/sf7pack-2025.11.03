<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251107125047 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '[User] Add created by column.';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__conference AS
            SELECT
              id,
              name,
              description,
              accessible,
              prerequisites,
              start_at,
              end_at
            FROM
              conference
        SQL);
        $this->addSql('DROP TABLE conference');
        $this->addSql(<<<'SQL'
            CREATE TABLE conference (
              id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
              created_by_id INTEGER NOT NULL,
              name VARCHAR(255) NOT NULL,
              description CLOB NOT NULL,
              accessible BOOLEAN NOT NULL,
              prerequisites CLOB DEFAULT NULL,
              start_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
              ,
              end_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
              ,
              CONSTRAINT FK_911533C8B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE
            )
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO conference (
              id, name, description, accessible,
              prerequisites, start_at, end_at
            )
            SELECT
              id,
              name,
              description,
              accessible,
              prerequisites,
              start_at,
              end_at
            FROM
              __temp__conference
        SQL);
        $this->addSql('DROP TABLE __temp__conference');
        $this->addSql('CREATE INDEX IDX_911533C8B03A8386 ON conference (created_by_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__conference AS
            SELECT
              id,
              name,
              description,
              accessible,
              prerequisites,
              start_at,
              end_at
            FROM
              conference
        SQL);
        $this->addSql('DROP TABLE conference');
        $this->addSql(<<<'SQL'
            CREATE TABLE conference (
              id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
              name VARCHAR(255) NOT NULL,
              description CLOB NOT NULL,
              accessible BOOLEAN NOT NULL,
              prerequisites CLOB DEFAULT NULL,
              start_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
              ,
              end_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
            )
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO conference (
              id, name, description, accessible,
              prerequisites, start_at, end_at
            )
            SELECT
              id,
              name,
              description,
              accessible,
              prerequisites,
              start_at,
              end_at
            FROM
              __temp__conference
        SQL);
        $this->addSql('DROP TABLE __temp__conference');
    }
}
