<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161218003839 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE coding_post_view ADD has_ip_data TINYINT(1) NOT NULL, ADD ip_data LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE gaming_post_view ADD has_ip_data TINYINT(1) NOT NULL, ADD ip_data LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE photography_post_photo_download ADD has_ip_data TINYINT(1) NOT NULL, ADD ip_data LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE photography_post_view ADD has_ip_data TINYINT(1) NOT NULL, ADD ip_data LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE push_notification_subscription ADD has_ip_data TINYINT(1) NOT NULL, ADD ip_data LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\'');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE coding_post_view DROP has_ip_data, DROP ip_data');
        $this->addSql('ALTER TABLE gaming_post_view DROP has_ip_data, DROP ip_data');
        $this->addSql('ALTER TABLE photography_post_photo_download DROP has_ip_data, DROP ip_data');
        $this->addSql('ALTER TABLE photography_post_view DROP has_ip_data, DROP ip_data');
        $this->addSql('ALTER TABLE push_notification_subscription DROP has_ip_data, DROP ip_data');
    }
}
