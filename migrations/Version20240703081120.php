<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240703081120 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE character_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE episode_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE location_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE character (id INT NOT NULL, origin_id INT NOT NULL, last_location_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, species VARCHAR(255) NOT NULL, type VARCHAR(255) DEFAULT NULL, gender VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_937AB03456A273CC ON character (origin_id)');
        $this->addSql('CREATE INDEX IDX_937AB034467B5E82 ON character (last_location_id)');
        $this->addSql('CREATE TABLE episode (id INT NOT NULL, name VARCHAR(255) NOT NULL, air_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, code VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE episode_character (episode_id INT NOT NULL, character_id INT NOT NULL, PRIMARY KEY(episode_id, character_id))');
        $this->addSql('CREATE INDEX IDX_2DB8260D362B62A0 ON episode_character (episode_id)');
        $this->addSql('CREATE INDEX IDX_2DB8260D1136BE75 ON episode_character (character_id)');
        $this->addSql('CREATE TABLE location (id INT NOT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, dimension VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE character ADD CONSTRAINT FK_937AB03456A273CC FOREIGN KEY (origin_id) REFERENCES location (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE character ADD CONSTRAINT FK_937AB034467B5E82 FOREIGN KEY (last_location_id) REFERENCES location (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE episode_character ADD CONSTRAINT FK_2DB8260D362B62A0 FOREIGN KEY (episode_id) REFERENCES episode (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE episode_character ADD CONSTRAINT FK_2DB8260D1136BE75 FOREIGN KEY (character_id) REFERENCES character (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE character_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE episode_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE location_id_seq CASCADE');
        $this->addSql('ALTER TABLE character DROP CONSTRAINT FK_937AB03456A273CC');
        $this->addSql('ALTER TABLE character DROP CONSTRAINT FK_937AB034467B5E82');
        $this->addSql('ALTER TABLE episode_character DROP CONSTRAINT FK_2DB8260D362B62A0');
        $this->addSql('ALTER TABLE episode_character DROP CONSTRAINT FK_2DB8260D1136BE75');
        $this->addSql('DROP TABLE character');
        $this->addSql('DROP TABLE episode');
        $this->addSql('DROP TABLE episode_character');
        $this->addSql('DROP TABLE location');
    }
}
