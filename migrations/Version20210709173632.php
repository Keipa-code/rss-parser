<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210709173632 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE news_item_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE parse_log_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE news_item (id INT NOT NULL, title VARCHAR(255) NOT NULL, link VARCHAR(400) NOT NULL, description VARCHAR(255) NOT NULL, guid UUID NOT NULL, pub_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, author VARCHAR(255) DEFAULT NULL, enclosure JSON DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN news_item.pub_date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE parse_log (id INT NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, request_method VARCHAR(255) NOT NULL, request_url VARCHAR(255) NOT NULL, response_http_code INT NOT NULL, response_body JSON NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN parse_log.date IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE news_item_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE parse_log_id_seq CASCADE');
        $this->addSql('DROP TABLE news_item');
        $this->addSql('DROP TABLE parse_log');
    }
}
