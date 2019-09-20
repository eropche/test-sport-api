<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190920103947 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE game_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE game_buffer_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE league_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE team_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE sport_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE game (id INT NOT NULL, team1_id INT DEFAULT NULL, team2_id INT DEFAULT NULL, language VARCHAR(255) NOT NULL, match_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, source VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_232B318CE72BCFA4 ON game (team1_id)');
        $this->addSql('CREATE INDEX IDX_232B318CF59E604A ON game (team2_id)');
        $this->addSql('CREATE TABLE game_buffer (id INT NOT NULL, game_id INT DEFAULT NULL, sport VARCHAR(255) NOT NULL, league VARCHAR(255) NOT NULL, team1 VARCHAR(255) NOT NULL, team2 VARCHAR(255) NOT NULL, language VARCHAR(255) NOT NULL, match_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, source VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_4C6F5D3AE48FD905 ON game_buffer (game_id)');
        $this->addSql('CREATE TABLE league (id INT NOT NULL, sport_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3EB4C3185E237E06 ON league (name)');
        $this->addSql('CREATE INDEX IDX_3EB4C318AC78BCF8 ON league (sport_id)');
        $this->addSql('CREATE TABLE leagues_teams (league_id INT NOT NULL, team_id INT NOT NULL, PRIMARY KEY(league_id, team_id))');
        $this->addSql('CREATE INDEX IDX_DB2AE55A58AFC4DE ON leagues_teams (league_id)');
        $this->addSql('CREATE INDEX IDX_DB2AE55A296CD8AE ON leagues_teams (team_id)');
        $this->addSql('CREATE TABLE team (id INT NOT NULL, sport_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C4E0A61FAC78BCF8 ON team (sport_id)');
        $this->addSql('CREATE TABLE sport (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1A85EFD25E237E06 ON sport (name)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318CE72BCFA4 FOREIGN KEY (team1_id) REFERENCES team (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318CF59E604A FOREIGN KEY (team2_id) REFERENCES team (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE game_buffer ADD CONSTRAINT FK_4C6F5D3AE48FD905 FOREIGN KEY (game_id) REFERENCES game (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE league ADD CONSTRAINT FK_3EB4C318AC78BCF8 FOREIGN KEY (sport_id) REFERENCES sport (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE leagues_teams ADD CONSTRAINT FK_DB2AE55A58AFC4DE FOREIGN KEY (league_id) REFERENCES league (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE leagues_teams ADD CONSTRAINT FK_DB2AE55A296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT FK_C4E0A61FAC78BCF8 FOREIGN KEY (sport_id) REFERENCES sport (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE game_buffer DROP CONSTRAINT FK_4C6F5D3AE48FD905');
        $this->addSql('ALTER TABLE leagues_teams DROP CONSTRAINT FK_DB2AE55A58AFC4DE');
        $this->addSql('ALTER TABLE game DROP CONSTRAINT FK_232B318CE72BCFA4');
        $this->addSql('ALTER TABLE game DROP CONSTRAINT FK_232B318CF59E604A');
        $this->addSql('ALTER TABLE leagues_teams DROP CONSTRAINT FK_DB2AE55A296CD8AE');
        $this->addSql('ALTER TABLE league DROP CONSTRAINT FK_3EB4C318AC78BCF8');
        $this->addSql('ALTER TABLE team DROP CONSTRAINT FK_C4E0A61FAC78BCF8');
        $this->addSql('DROP SEQUENCE game_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE game_buffer_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE league_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE team_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE sport_id_seq CASCADE');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE game_buffer');
        $this->addSql('DROP TABLE league');
        $this->addSql('DROP TABLE leagues_teams');
        $this->addSql('DROP TABLE team');
        $this->addSql('DROP TABLE sport');
    }
}
