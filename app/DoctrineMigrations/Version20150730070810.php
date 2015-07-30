<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150730070810 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE photography_post_photo DROP FOREIGN KEY FK_AA35006E8F579A06');
        $this->addSql('DROP INDEX IDX_AA35006E8F579A06 ON photography_post_photo');
        $this->addSql('ALTER TABLE photography_post_photo CHANGE news_post photography_post INT DEFAULT NULL');
        $this->addSql('ALTER TABLE photography_post_photo ADD CONSTRAINT FK_AA35006E7D4AC8F5 FOREIGN KEY (photography_post) REFERENCES photography_post (id)');
        $this->addSql('CREATE INDEX IDX_AA35006E7D4AC8F5 ON photography_post_photo (photography_post)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE photography_post_photo DROP FOREIGN KEY FK_AA35006E7D4AC8F5');
        $this->addSql('DROP INDEX IDX_AA35006E7D4AC8F5 ON photography_post_photo');
        $this->addSql('ALTER TABLE photography_post_photo CHANGE photography_post news_post INT DEFAULT NULL');
        $this->addSql('ALTER TABLE photography_post_photo ADD CONSTRAINT FK_AA35006E8F579A06 FOREIGN KEY (news_post) REFERENCES photography_post (id)');
        $this->addSql('CREATE INDEX IDX_AA35006E8F579A06 ON photography_post_photo (news_post)');
    }
}
