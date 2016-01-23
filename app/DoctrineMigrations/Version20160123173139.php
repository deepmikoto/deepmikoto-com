<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160123173139 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE coding_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, image VARCHAR(255) NOT NULL, created DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE coding_post_category (coding_post_id INT NOT NULL, coding_category_id INT NOT NULL, INDEX IDX_5EED7E71A586C602 (coding_post_id), INDEX IDX_5EED7E715E5C2F4 (coding_category_id), PRIMARY KEY(coding_post_id, coding_category_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE coding_post_category ADD CONSTRAINT FK_5EED7E71A586C602 FOREIGN KEY (coding_post_id) REFERENCES coding_post (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE coding_post_category ADD CONSTRAINT FK_5EED7E715E5C2F4 FOREIGN KEY (coding_category_id) REFERENCES coding_category (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE coding_post_category DROP FOREIGN KEY FK_5EED7E715E5C2F4');
        $this->addSql('DROP TABLE coding_category');
        $this->addSql('DROP TABLE coding_post_category');
    }
}
