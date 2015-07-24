<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150723223220 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE admin_users (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(100) NOT NULL, email VARCHAR(100) NOT NULL, salt VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, date_registered DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE admin_user_roles (admin_user_id INT NOT NULL, role_id INT NOT NULL, INDEX IDX_9CC2731A6352511C (admin_user_id), INDEX IDX_9CC2731AD60322AC (role_id), PRIMARY KEY(admin_user_id, role_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_roles (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, date_created DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE admin_user_roles ADD CONSTRAINT FK_9CC2731A6352511C FOREIGN KEY (admin_user_id) REFERENCES admin_users (id)');
        $this->addSql('ALTER TABLE admin_user_roles ADD CONSTRAINT FK_9CC2731AD60322AC FOREIGN KEY (role_id) REFERENCES user_roles (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE admin_user_roles DROP FOREIGN KEY FK_9CC2731A6352511C');
        $this->addSql('ALTER TABLE admin_user_roles DROP FOREIGN KEY FK_9CC2731AD60322AC');
        $this->addSql('DROP TABLE admin_users');
        $this->addSql('DROP TABLE admin_user_roles');
        $this->addSql('DROP TABLE user_roles');
    }
}
