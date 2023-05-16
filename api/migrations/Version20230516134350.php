<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230516134350 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE booking_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE booking_state_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE cottage_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE booking (id INT NOT NULL, booking_state_id INT DEFAULT NULL, cottage_id INT NOT NULL, arrival_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, departure_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, duration VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E00CEDDE3EECA24C ON booking (booking_state_id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDE17FF9E93 ON booking (cottage_id)');
        $this->addSql('COMMENT ON COLUMN booking.duration IS \'(DC2Type:dateinterval)\'');
        $this->addSql('COMMENT ON COLUMN booking.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN booking.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE booking_user (booking_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(booking_id, user_id))');
        $this->addSql('CREATE INDEX IDX_9502F4073301C60 ON booking_user (booking_id)');
        $this->addSql('CREATE INDEX IDX_9502F407A76ED395 ON booking_user (user_id)');
        $this->addSql('CREATE TABLE booking_state (id INT NOT NULL, state VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE cottage (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE cottage_user (cottage_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(cottage_id, user_id))');
        $this->addSql('CREATE INDEX IDX_A925B0BA17FF9E93 ON cottage_user (cottage_id)');
        $this->addSql('CREATE INDEX IDX_A925B0BAA76ED395 ON cottage_user (user_id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE3EECA24C FOREIGN KEY (booking_state_id) REFERENCES booking_state (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE17FF9E93 FOREIGN KEY (cottage_id) REFERENCES cottage (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE booking_user ADD CONSTRAINT FK_9502F4073301C60 FOREIGN KEY (booking_id) REFERENCES booking (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE booking_user ADD CONSTRAINT FK_9502F407A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cottage_user ADD CONSTRAINT FK_A925B0BA17FF9E93 FOREIGN KEY (cottage_id) REFERENCES cottage (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cottage_user ADD CONSTRAINT FK_A925B0BAA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE booking_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE booking_state_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE cottage_id_seq CASCADE');
        $this->addSql('ALTER TABLE booking DROP CONSTRAINT FK_E00CEDDE3EECA24C');
        $this->addSql('ALTER TABLE booking DROP CONSTRAINT FK_E00CEDDE17FF9E93');
        $this->addSql('ALTER TABLE booking_user DROP CONSTRAINT FK_9502F4073301C60');
        $this->addSql('ALTER TABLE booking_user DROP CONSTRAINT FK_9502F407A76ED395');
        $this->addSql('ALTER TABLE cottage_user DROP CONSTRAINT FK_A925B0BA17FF9E93');
        $this->addSql('ALTER TABLE cottage_user DROP CONSTRAINT FK_A925B0BAA76ED395');
        $this->addSql('DROP TABLE booking');
        $this->addSql('DROP TABLE booking_user');
        $this->addSql('DROP TABLE booking_state');
        $this->addSql('DROP TABLE cottage');
        $this->addSql('DROP TABLE cottage_user');
    }
}
