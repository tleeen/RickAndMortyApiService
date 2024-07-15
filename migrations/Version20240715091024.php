<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240715091024 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX UNIQ_937AB0345E237E06 ON character (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_937AB034C53D045F ON character (image)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DDAA1CDA5E237E06 ON episode (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DDAA1CDA77153098 ON episode (code)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5E9E89CB5E237E06 ON location (name)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP INDEX UNIQ_DDAA1CDA5E237E06');
        $this->addSql('DROP INDEX UNIQ_DDAA1CDA77153098');
        $this->addSql('DROP INDEX UNIQ_937AB0345E237E06');
        $this->addSql('DROP INDEX UNIQ_937AB034C53D045F');
        $this->addSql('DROP INDEX UNIQ_5E9E89CB5E237E06');
    }
}
