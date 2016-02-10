<?php

namespace DeepMikoto\AdminBundle\DataFixtures\ORM;


use DeepMikoto\ApiBundle\Entity\StaticPage;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadStaticPages extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
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
            $helpPage = new StaticPage();
            $helpPage
                ->setName( 'help' )
                ->setContent( '<h2>Help page</h2><p>Lorem ipsum ... </p>' )
            ;
            $manager->persist( $helpPage );
            $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 3;
    }
} 