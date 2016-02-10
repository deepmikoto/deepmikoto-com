<?php
/**
 * Created by PhpStorm.
 * User: MiKoRiza-OnE
 * Date: 7/23/2015
 * Time: 23:17
 */

namespace DeepMikoto\AdminBundle\DataFixtures\ORM;


use DeepMikoto\AdminBundle\Entity\AdminUser;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadAdminUser extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer( ContainerInterface $container = null )
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function load( ObjectManager $manager )
    {
        /** @var \DeepMikoto\AdminBundle\Entity\UserRole $superAdminRole */
        $superAdminRole = $this->getReference( 'Super Admin' );
        $adminUser = new AdminUser();
        $adminUser
            ->setUsername( 'deepmikoto' )
            ->setSalt( md5( 'MiKoRiZa' ) )
            ->setEmail( 'deepmikoto@gmail.com' )
            ->addRole( $superAdminRole )
        ;
        /** @var \Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder $encoder */
        $encoder = $this->container->get( 'security.encoder_factory' )->getEncoder( $adminUser );
        $adminUser->setPassword( $encoder->encodePassword( 'password', $adminUser->getSalt() ) );
        $manager->persist( $adminUser );
        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 2;
    }
} 