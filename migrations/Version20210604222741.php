<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210604222741 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE meeting (id INT AUTO_INCREMENT NOT NULL, uuid VARCHAR(255) NOT NULL, host_id VARCHAR(255) NOT NULL, host_email VARCHAR(255) NOT NULL, topic VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, start_time DATETIME NOT NULL, duration VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, start_url LONGTEXT NOT NULL, join_url LONGTEXT NOT NULL, password VARCHAR(255) NOT NULL, h323_password VARCHAR(255) NOT NULL, pstn_password VARCHAR(255) NOT NULL, encrypted_password LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE meeting');
    }
}
