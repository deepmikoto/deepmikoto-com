<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150829095355 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE photography_post_photo_download (id INT AUTO_INCREMENT NOT NULL, photography_post_photo INT DEFAULT NULL, user VARCHAR(255) NOT NULL, ip VARCHAR(50) NOT NULL, date DATETIME NOT NULL, INDEX IDX_80A7255BAA35006E (photography_post_photo), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE photography_post_photo_download ADD CONSTRAINT FK_80A7255BAA35006E FOREIGN KEY (photography_post_photo) REFERENCES photography_post_photo (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE photography_post_photo_download');
    }
}
