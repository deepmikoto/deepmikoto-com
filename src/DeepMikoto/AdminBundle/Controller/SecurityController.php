<?php
/**
 * Created by PhpStorm.
 * User: MiKoRiza-OnE
 * Date: 7/23/2015
 * Time: 23:47
 */

namespace DeepMikoto\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class SecurityController
 *
 * @package DeepMikoto\AdminBundle\Controller
 */
class SecurityController extends Controller
{
    /**
     * handles admin login action
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginAction()
    {
        $authenticationUtils = $this->get( 'security.authentication_utils' );
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render( '@DeepMikotoAdmin/Security/login.html.twig', [
                'last_username' => $lastUsername,
                'error'         => $error,
            ]
        );
    }
} 