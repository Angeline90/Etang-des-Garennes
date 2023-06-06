<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230606091645 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cottage ADD banner_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cottage ADD card_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cottage ADD CONSTRAINT FK_68EE8CED684EC833 FOREIGN KEY (banner_id) REFERENCES image (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cottage ADD CONSTRAINT FK_68EE8CED4ACC9A20 FOREIGN KEY (card_id) REFERENCES image (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_68EE8CED684EC833 ON cottage (banner_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_68EE8CED4ACC9A20 ON cottage (card_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE cottage DROP CONSTRAINT FK_68EE8CED684EC833');
        $this->addSql('ALTER TABLE cottage DROP CONSTRAINT FK_68EE8CED4ACC9A20');
        $this->addSql('DROP INDEX UNIQ_68EE8CED684EC833');
        $this->addSql('DROP INDEX UNIQ_68EE8CED4ACC9A20');
        $this->addSql('ALTER TABLE cottage DROP banner_id');
        $this->addSql('ALTER TABLE cottage DROP card_id');
    }
}
