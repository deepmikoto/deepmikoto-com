<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161113142036 extends AbstractMigration implements ContainerAwareInterface
{
    /**
     * @var Container
     */
    private $container;

    /**
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE coding_post_view ADD user_browser_data LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', DROP browser');
        $this->addSql('ALTER TABLE gaming_post_view ADD user_browser_data LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', DROP browser');
        $this->addSql('ALTER TABLE photography_post_photo_download ADD user_browser_data LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE photography_post_view ADD user_browser_data LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', DROP browser');
    }

    /**
     * @param Schema $schema
     */
    public function postUp(Schema $schema)
    {
        $em = $this->container->get('doctrine.orm.entity_manager');
        $em
            ->createQueryBuilder()
            ->update('DeepMikotoApiBundle:CodingPostView', 'v')
            ->set('v.userBrowserData', ':array')
            ->setParameter('array', serialize([]))
            ->getQuery()
            ->execute()
        ;
        $em
            ->createQueryBuilder()
            ->update('DeepMikotoApiBundle:GamingPostView', 'v')
            ->set('v.userBrowserData', ':array')
            ->setParameter('array', serialize([]))
            ->getQuery()
            ->execute()
        ;
        $em
            ->createQueryBuilder()
            ->update('DeepMikotoApiBundle:PhotographyPostView', 'v')
            ->set('v.userBrowserData', ':array')
            ->setParameter('array', serialize([]))
            ->getQuery()
            ->execute()
        ;
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE coding_post_view ADD browser VARCHAR(50) NOT NULL COLLATE utf8_unicode_ci, DROP user_browser_data');
        $this->addSql('ALTER TABLE gaming_post_view ADD browser VARCHAR(50) NOT NULL COLLATE utf8_unicode_ci, DROP user_browser_data');
        $this->addSql('ALTER TABLE photography_post_photo_download DROP user_browser_data');
        $this->addSql('ALTER TABLE photography_post_view ADD browser VARCHAR(50) NOT NULL COLLATE utf8_unicode_ci, DROP user_browser_data');
    }
}
