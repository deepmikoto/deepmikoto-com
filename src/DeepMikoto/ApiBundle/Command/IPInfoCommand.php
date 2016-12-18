<?php

namespace DeepMikoto\ApiBundle\Command;

use DeepMikoto\ApiBundle\Entity\IPApiCall;
use DeepMikoto\ApiBundle\Entity\TrackingEntity;
use DeepMikoto\ApiBundle\Services\TrackingService;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class IPInfoCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('get:ip:info')
            ->setDescription('Hello PhpStorm');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var EntityManager $em */
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        /** @var TrackingService $trackingService */
        $trackingService = $this->getContainer()->get('deepmikoto.api.tracking_manager');
        $apiCallsLimit = 100;
        $trackingEntities = array_merge(
            $em->getRepository('DeepMikotoApiBundle:CodingPostView')->findBy([ 'hasIpData' => false ], [ 'date' => 'ASC' ], $apiCallsLimit ),
            $em->getRepository('DeepMikotoApiBundle:GamingPostView')->findBy([ 'hasIpData' => false ], [ 'date' => 'ASC' ], $apiCallsLimit ),
            $em->getRepository('DeepMikotoApiBundle:PhotographyPostView')->findBy([ 'hasIpData' => false ], [ 'date' => 'ASC' ], $apiCallsLimit ),
            $em->getRepository('DeepMikotoApiBundle:PhotographyPostPhotoDownload')->findBy([ 'hasIpData' => false ], [ 'date' => 'ASC' ], $apiCallsLimit ),
            $em->getRepository('DeepMikotoApiBundle:PushNotificationSubscription')->findBy([ 'hasIpData' => false ], [ 'createdAt' => 'ASC' ], $apiCallsLimit )
        );
        $apiCalls = 0;
        /** @var TrackingEntity $trackingEntity */
        foreach ( $trackingEntities as $trackingEntity ) {
            if ( ! ( $apiCalls < $apiCallsLimit ) || $trackingService->isIpPrivate( $trackingEntity->getIp() ) ) continue;
            $apiCall = new IPApiCall( $trackingEntity->getIp() );
            $data = $trackingService->getIpData( $trackingEntity->getIp() );
            $apiCalls++;
            if( array_key_exists( 'status', $data  ) && $data['status'] == IPApiCall::SUCCESS_STATUS ){
                $trackingEntity
                    ->setHasIpData( true )
                    ->setIpData( $data )
                ;
                $em->persist( $trackingEntity );
            } else {
                $apiCall
                    ->setStatus( IPApiCall::FAILED_STATUS )
                    ->setErrorResponse( $data )
                ;
            }
            $em->persist( $apiCall );
        }
        $em->flush();
    }
}
