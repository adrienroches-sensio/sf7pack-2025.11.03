<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251104153634 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '[Conference, Volunteering, Organization] Create relations.';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE conference_organization (
              conference_id INTEGER NOT NULL,
              organization_id INTEGER NOT NULL,
              PRIMARY KEY(conference_id, organization_id),
              CONSTRAINT FK_4E2E09AE604B8382 FOREIGN KEY (conference_id) REFERENCES conference (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE,
              CONSTRAINT FK_4E2E09AE32C8A3DE FOREIGN KEY (organization_id) REFERENCES organization (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
            )
        SQL);
        $this->addSql('CREATE INDEX IDX_4E2E09AE604B8382 ON conference_organization (conference_id)');
        $this->addSql('CREATE INDEX IDX_4E2E09AE32C8A3DE ON conference_organization (organization_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__volunteering AS SELECT id, start_at, end_at FROM volunteering');
        $this->addSql('DROP TABLE volunteering');
        $this->addSql(<<<'SQL'
            CREATE TABLE volunteering (
              id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
              conference_id INTEGER NOT NULL,
              start_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
              ,
              end_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
              ,
              CONSTRAINT FK_7854E8EE604B8382 FOREIGN KEY (conference_id) REFERENCES conference (id) NOT DEFERRABLE INITIALLY IMMEDIATE
            )
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO volunteering (id, start_at, end_at)
            SELECT
              id,
              start_at,
              end_at
            FROM
              __temp__volunteering
        SQL);
        $this->addSql('DROP TABLE __temp__volunteering');
        $this->addSql('CREATE INDEX IDX_7854E8EE604B8382 ON volunteering (conference_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE conference_organization');
        $this->addSql('CREATE TEMPORARY TABLE __temp__volunteering AS SELECT id, start_at, end_at FROM volunteering');
        $this->addSql('DROP TABLE volunteering');
        $this->addSql(<<<'SQL'
            CREATE TABLE volunteering (
              id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
              start_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
              ,
              end_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
            )
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO volunteering (id, start_at, end_at)
            SELECT
              id,
              start_at,
              end_at
            FROM
              __temp__volunteering
        SQL);
        $this->addSql('DROP TABLE __temp__volunteering');
    }
}
