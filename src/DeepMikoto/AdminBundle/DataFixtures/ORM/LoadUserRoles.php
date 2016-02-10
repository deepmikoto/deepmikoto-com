<?php
/**
 * Created by PhpStorm.
 * User: MiKoRiza-OnE
 * Date: 7/23/2015
 * Time: 23:07
 */

namespace DeepMikoto\AdminBundle\DataFixtures\ORM;

use DeepMikoto\AdminBundle\Entity\UserRole;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadUserRoles
 *
 * @package DeepMikoto\AdminBundle\DataFixtures\ORM
 */
class LoadUserRoles extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load( ObjectManager $manager )
    {
        $initialRoles = [
            'User'          => 'ROLE_USER',
            'Admin'         => 'ROLE_ADMIN',
            'Super Admin'   => 'ROLE_SUPER_ADMIN'
        ];
        foreach( $initialRoles as $name => $role ){
            $userRole = new UserRole();
            $userRole
                ->setName( $name )
                ->setRole( $role )
            ;
            $manager->persist( $userRole );
            $manager->flush();
            $this->addReference( $name, $userRole );
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1;
    }
} 