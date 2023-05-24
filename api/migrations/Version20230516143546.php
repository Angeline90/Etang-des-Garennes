<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230516143546 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE image_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE image (id INT NOT NULL, cottage_id INT DEFAULT NULL, path VARCHAR(255) DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C53D045F17FF9E93 ON image (cottage_id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F17FF9E93 FOREIGN KEY (cottage_id) REFERENCES cottage (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cottage ADD description TEXT NOT NULL');
        $this->addSql('ALTER TABLE cottage ADD price DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE cottage ADD capacity INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE image_id_seq CASCADE');
        $this->addSql('ALTER TABLE image DROP CONSTRAINT FK_C53D045F17FF9E93');
        $this->addSql('DROP TABLE image');
        $this->addSql('ALTER TABLE cottage DROP description');
        $this->addSql('ALTER TABLE cottage DROP price');
        $this->addSql('ALTER TABLE cottage DROP capacity');
    }
}
