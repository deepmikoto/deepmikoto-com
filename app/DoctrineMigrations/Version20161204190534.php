<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161204190534 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE photography_post_photo ADD resolution VARCHAR(20) DEFAULT NULL, CHANGE camera camera VARCHAR(50) DEFAULT NULL, CHANGE exposure exposure VARCHAR(20) DEFAULT NULL, CHANGE iso iso VARCHAR(10) DEFAULT NULL, CHANGE aperture aperture VARCHAR(10) DEFAULT NULL, CHANGE focal_length focal_length VARCHAR(15) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE photography_post_photo DROP resolution, CHANGE camera camera VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE exposure exposure VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE iso iso VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE aperture aperture VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE focal_length focal_length VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
    }
}
