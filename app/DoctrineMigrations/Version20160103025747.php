<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160103025747 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE coding_post_view (id INT AUTO_INCREMENT NOT NULL, post INT DEFAULT NULL, ip VARCHAR(50) NOT NULL, browser VARCHAR(50) NOT NULL, referer_domain VARCHAR(100) DEFAULT NULL, referer_url VARCHAR(100) DEFAULT NULL, date DATETIME NOT NULL, INDEX IDX_D7A11D995A8A6C8D (post), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gaming_post_view (id INT AUTO_INCREMENT NOT NULL, post INT DEFAULT NULL, ip VARCHAR(50) NOT NULL, browser VARCHAR(50) NOT NULL, referer_domain VARCHAR(100) DEFAULT NULL, referer_url VARCHAR(100) DEFAULT NULL, date DATETIME NOT NULL, INDEX IDX_40B5B62B5A8A6C8D (post), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE photography_post_view (id INT AUTO_INCREMENT NOT NULL, post INT DEFAULT NULL, ip VARCHAR(50) NOT NULL, browser VARCHAR(50) NOT NULL, referer_domain VARCHAR(100) DEFAULT NULL, referer_url VARCHAR(100) DEFAULT NULL, date DATETIME NOT NULL, INDEX IDX_7769CDFC5A8A6C8D (post), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE coding_post_view ADD CONSTRAINT FK_D7A11D995A8A6C8D FOREIGN KEY (post) REFERENCES coding_post (id)');
        $this->addSql('ALTER TABLE gaming_post_view ADD CONSTRAINT FK_40B5B62B5A8A6C8D FOREIGN KEY (post) REFERENCES gaming_post (id)');
        $this->addSql('ALTER TABLE photography_post_view ADD CONSTRAINT FK_7769CDFC5A8A6C8D FOREIGN KEY (post) REFERENCES photography_post (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE coding_post_view');
        $this->addSql('DROP TABLE gaming_post_view');
        $this->addSql('DROP TABLE photography_post_view');
    }
}
