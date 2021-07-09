<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210709192542 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE news_item ALTER title TYPE VARCHAR(3000)');
        $this->addSql('ALTER TABLE news_item ALTER description TYPE VARCHAR(3000)');
        $this->addSql('ALTER TABLE news_item ALTER author TYPE VARCHAR(3000)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE news_item ALTER title TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE news_item ALTER description TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE news_item ALTER author TYPE VARCHAR(255)');
    }
}
