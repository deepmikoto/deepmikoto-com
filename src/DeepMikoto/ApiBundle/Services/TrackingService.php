<?php


namespace DeepMikoto\ApiBundle\Services;

use DeepMikoto\ApiBundle\Entity\CodingPost;
use DeepMikoto\ApiBundle\Entity\CodingPostView;
use DeepMikoto\ApiBundle\Entity\GamingPost;
use DeepMikoto\ApiBundle\Entity\GamingPostView;
use DeepMikoto\ApiBundle\Entity\PhotographyPost;
use DeepMikoto\ApiBundle\Entity\PhotographyPostView;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CodingService
 *
 * @package DeepMikoto\ApiBundle\Services
 */
class TrackingService
{
    private $em;

    /**
     * initialize service components
     *
     * @param EntityManager $em
     */
    public function __construct( EntityManager $em )
    {
        $this->em = $em;
    }

    /**
     * @param CodingPost | GamingPost | PhotographyPost $post
     * @param Request $request
     * @return bool
     */
    public function addPostView( $post, $request )
    {
        $clientIp = $request->getClientIp();
        if( $this->isIpPrivate( $clientIp ) ) return false;
        $clientBrowser = $this->getClientBrowser( $request->headers->get( 'user-agent' ) );
        $clientRefererDomain = parse_url( $request->headers->get( 'referer' ), PHP_URL_HOST );
        $clientReferer = $request->headers->get( 'referer' );
        if( $clientRefererDomain == $request->getHost() ){
            $clientRefererDomain = null;
            $clientReferer = null;
        }

        if( $post instanceof CodingPost ){
            $view = new CodingPostView();
        } else if ( $post instanceof GamingPost ){
            $view = new GamingPostView();
        } elseif ( $post instanceof PhotographyPost ){
            $view = new PhotographyPostView();
        } else {
            return false;
        }

        $fiveSecondsFromNow = new \DateTime( '+5' );


        $view->setPost( $post )->setIp( $clientIp )->setBrowser( $clientBrowser )->setRefererDomain( $clientRefererDomain )->setRefererUrl( $clientReferer );
        $this->em->persist( $view );
        $this->em->flush( $view );

        return true;
    }

    /**
     * @param $ip
     * @return bool
     */
    private function isIpPrivate ( $ip )
    {
        $pri_addrs = [
            '10.0.0.0|10.255.255.255',      // single class A network
            '172.16.0.0|172.31.255.255',    // 16 contiguous class B network
            '192.168.0.0|192.168.255.255',  // 256 contiguous class C network
            '169.254.0.0|169.254.255.255',  // Link-local address also referred to as Automatic Private IP Addressing
            '127.0.0.0|127.255.255.255'     // localhost
        ];

        $long_ip = ip2long ( $ip );
        if( $long_ip != -1 ) {
            foreach ( $pri_addrs as $pri_addr ) {
                list ( $start, $end ) = explode( '|', $pri_addr );
                if ( $long_ip >= ip2long ( $start ) && $long_ip <= ip2long ( $end ) ) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @param $user_agent
     * @return string
     */
    private function getClientBrowser( $user_agent )
    {
        if( strpos( $user_agent, 'MSIE' ) !== false )
            $browser = 'Internet Explorer';
        elseif( strpos($user_agent, 'Trident' ) !== false ) //For Supporting IE 11
            $browser = 'Internet explorer';
        elseif( strpos( $user_agent, 'Firefox' ) !== false )
            $browser = 'Mozilla Firefox';
        elseif( strpos( $user_agent, 'Chrome' ) !== false )
            $browser = 'Google Chrome';
        elseif( strpos( $user_agent, 'Opera Mini' ) !== false )
            $browser = "Opera Mini";
        elseif( strpos( $user_agent, 'Opera' ) !== false )
            $browser = "Opera";
        elseif( strpos( $user_agent, 'Safari' ) !== false )
            $browser = "Safari";
        else
            $browser = 'Something else';
        
        return $browser;

    }
} 