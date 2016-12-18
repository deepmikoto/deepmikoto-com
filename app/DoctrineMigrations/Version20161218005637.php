<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161218005637 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('UPDATE gaming_post_view SET ip_data = \'a:0:{}\' WHERE ip_data = \'\'');
        $this->addSql('UPDATE coding_post_view SET ip_data = \'a:0:{}\' WHERE ip_data = \'\'');
        $this->addSql('UPDATE photography_post_view SET ip_data = \'a:0:{}\' WHERE ip_data = \'\'');
        $this->addSql('UPDATE photography_post_photo_download SET ip_data = \'a:0:{}\' WHERE ip_data = \'\'');
        $this->addSql('UPDATE push_notification_subscription SET ip_data = \'a:0:{}\' WHERE ip_data = \'\'');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
    }
}
