<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170114164225 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE coding_demo_page (id INT AUTO_INCREMENT NOT NULL, coding_post INT DEFAULT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, style LONGTEXT NOT NULL, html LONGTEXT NOT NULL, js LONGTEXT NOT NULL, UNIQUE INDEX UNIQ_34A1A49989D9B62 (slug), UNIQUE INDEX UNIQ_34A1A49438396C1 (coding_post), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE coding_demo_page_view (id INT AUTO_INCREMENT NOT NULL, demo_page INT DEFAULT NULL, ip VARCHAR(50) NOT NULL, user_browser_data LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', has_ip_data TINYINT(1) NOT NULL, ip_data LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', referer_domain VARCHAR(100) DEFAULT NULL, referer_url VARCHAR(100) DEFAULT NULL, date DATETIME NOT NULL, INDEX IDX_9FBF0D83E343CB55 (demo_page), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE coding_demo_page ADD CONSTRAINT FK_34A1A49438396C1 FOREIGN KEY (coding_post) REFERENCES coding_post (id)');
        $this->addSql('ALTER TABLE coding_demo_page_view ADD CONSTRAINT FK_9FBF0D83E343CB55 FOREIGN KEY (demo_page) REFERENCES coding_demo_page (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE coding_demo_page_view DROP FOREIGN KEY FK_9FBF0D83E343CB55');
        $this->addSql('DROP TABLE coding_demo_page');
        $this->addSql('DROP TABLE coding_demo_page_view');
    }
}
