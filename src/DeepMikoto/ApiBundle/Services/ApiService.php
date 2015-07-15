<?php
/**
 * Created by PhpStorm.
 * User: MiKoRiza-OnE
 * Date: 6/6/2015
 * Time: 14:25
 */

namespace DeepMikoto\ApiBundle\Services;

use Doctrine\ORM\EntityManager;
use JMS\Serializer\Serializer;

use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Service for handling general api logic
 *
 * Class ApiService
 * @package DeepMikoto\ApiBundle\Services
 */
class ApiService
{
    private $em;
    private $container;
    private $request;
    private $serializer;

    /**
     * initialize service components
     *
     * @param Container $container
     * @param EntityManager $em
     * @param RequestStack $requestStack
     * @param Serializer $serializer
     */
    public function __construct(Container $container, EntityManager $em, RequestStack $requestStack, Serializer $serializer)
    {
        $this->em = $em;
        $this->container = $container;
        $this->request = $requestStack->getCurrentRequest();
        $this->serializer = $serializer;
    }

    /**
     * returns logged in user or null
     *
     * @return mixed
     */
    private function getUser()
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        return $user != 'anon.' ? $user : null;
    }

    /**
     * return logged in user's attributes
     * needed in our Marionette app
     *
     * @return string
     */
    public function getUserInfo()
    {
        $user = $this->getUser();

        return $this->serializer->serialize($user, 'json');
    }
} 