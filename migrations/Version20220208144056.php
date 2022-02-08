<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220208144056 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE maison (id INT AUTO_INCREMENT NOT NULL, commercial_id INT NOT NULL, title VARCHAR(100) NOT NULL, description LONGTEXT NOT NULL, surface INT NOT NULL, rooms INT NOT NULL, bedrooms INT DEFAULT NULL, price INT NOT NULL, img1 VARCHAR(30) NOT NULL, img2 VARCHAR(30) DEFAULT NULL, INDEX IDX_F90CB66D7854071C (commercial_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE maison ADD CONSTRAINT FK_F90CB66D7854071C FOREIGN KEY (commercial_id) REFERENCES commercial (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE maison');
        $this->addSql('ALTER TABLE commercial CHANGE name name VARCHAR(45) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE messenger_messages CHANGE body body LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE headers headers LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE queue_name queue_name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
