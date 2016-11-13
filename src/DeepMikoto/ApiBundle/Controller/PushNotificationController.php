<?php

namespace DeepMikoto\ApiBundle\Controller;

use DeepMikoto\ApiBundle\Entity\PushNotificationSubscription;
use DeepMikoto\ApiBundle\Security\ApiResponseStatus;
use DeepMikoto\ApiBundle\Security\BrowserDetector;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class PushNotificationController
 * @package DeepMikoto\AdminBundle\Controller
 */
class PushNotificationController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function saveSubscriptionToDBAction( Request $request )
    {
        $endpoint = $request->get('endpoint');
        $keys = $request->get('keys');
        if ( $endpoint != null && is_array( $keys ) && array_key_exists( 'auth', $keys ) && array_key_exists( 'p256dh', $keys ) ) {
            $auth = $keys[ 'auth' ];
            $userPublicKey = $keys[ 'p256dh' ];
            if ( $auth != null && $userPublicKey != null ) {
                $em = $this->get('doctrine.orm.entity_manager');
                $subscription = new PushNotificationSubscription();
                $subscription
                    ->setEndpoint( $endpoint )
                    ->setUserPublicKey( $userPublicKey )
                    ->setUserAuthToken( $auth )
                    ->setUserBrowserData( $this->get('deepmikoto.api.tracking_manager')->getUserBrowserInfo() )
                    ->setIp( $request->getClientIp() )
                ;
                $em->persist( $subscription );
                $em->flush();

                return new JsonResponse( ApiResponseStatus::$ALL_OK );
            } else {
                return new JsonResponse( ApiResponseStatus::$INVALID_REQUEST_PARAMETERS, 400 );
            }
        } else {
            return new JsonResponse( ApiResponseStatus::$MISSING_REQUEST_PARAMETERS, 400 );
        }
    }
}
