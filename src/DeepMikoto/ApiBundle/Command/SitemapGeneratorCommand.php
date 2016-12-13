<?php

namespace DeepMikoto\ApiBundle\Command;

use DeepMikoto\ApiBundle\Entity\SiteMapLinkSet;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Routing\Router;

/**
 * Class SitemapGeneratorCommand
 * @package DeepMikoto\ApiBundle\Command
 */
class SitemapGeneratorCommand extends ContainerAwareCommand
{
    /**
     * @var Router
     */
    private $router;
    /**
     * @var EntityManager
     */
    private $em;
    /**
     * @var OutputInterface
     */
    private $output;
    /**
     * @var \DateTime
     */
    private $startedAt;
    /**
     * @var \DateTime
     */
    private $oneWeekAgo;
    private $file;
    private $siteName;
    private $siteScheme;
    private $childPIDs;
    private $baseDir;
    private $firstRun;
    private $linkSetLimit;

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('run:sitemap:generator')
            ->setDescription('Generates sitemaps for new site content')
            ->addOption(
                'first-run',
                null,
                InputOption::VALUE_NONE,
                'If set, we generate sitemaps for all database entries, not only from the past week'
            )
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        parent::__construct();
        $this->siteName = 'deepmikoto.com';
        $this->siteScheme = 'https';
        $this->countRouteListe = 0;
        $this->childPIDs = [];
        $this->startedAt = new \DateTime();
        $this->oneWeekAgo = new \DateTime('-1 week');
        $this->oneWeekAgo->setTime( 0, 0, 0 );
        $this->linkSetLimit = 49999;
    }

    /**
     * dependencies and setup env
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    private function initDependenciesAndEnvironment( InputInterface $input, OutputInterface $output )
    {
        /**
         * increase default PHP restrictions
         */
        ini_set('memory_limit', '3072M');
        set_time_limit(0);
        error_reporting(E_ERROR);
        gc_enable();

        /**
         * define script components
         */
        $this->output = $output;
        $container = $this->getContainer();
        $this->siteName = $container->getParameter('web_host');
        $this->router = $container->get('router');
        $this->em = $container->get('doctrine.orm.entity_manager');
        $this->baseDir = $container->get('kernel')->getRootDir() . '/../web/sitemap';
        $this->firstRun = $input->getOption( 'first-run' );
        if ( !file_exists( $this->baseDir ) && !is_dir( $this->baseDir ) ) {
            mkdir( $this->baseDir );
        }

        /**
         * set router context
         */
        $context = $this->router->getContext();
        $context->setHost($this->siteName);
        $context->setScheme($this->siteScheme);
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->initDependenciesAndEnvironment( $input, $output );
        $this->cleanupIfNecessary();
        $this->generateLinkSet( 'siteRoutes' );
        $this->generateLinkSet( 'codingPostsRoutes' );
        $this->generateLinkSet( 'gamingPostsRoutes' );
        $this->generateLinkSet( 'photographyPostsRoutes' );
        $this->generateLinkSet( 'codingCategoriesRoutes' );
        $this->waitForChildServicesToFinish();
        /**
         * generate sitemap.xml file
         */
        $this->generateSiteMapIndex();
        $output->writeln('all done!');
        $output->writeln('<info>Memory used: ' . $this->getMemoryUsage() .'</info>');
    }

    /**
     * @return string
     */
    private function getMemoryUsage()
    {
        return ( memory_get_peak_usage( true ) / 1024 / 1024 ) . " MB";
    }

    /**
     * @param $name
     * @param array $params
     * @return string
     */
    private function generateRoute( $name, $params = [] )
    {
        return $this->router->generate( $name, $params, Router::ABSOLUTE_URL );
    }

    /**
     * @param $routeName
     * @param $routeParams
     */
    private function addURLToLinkSet( $routeName, $routeParams = [] )
    {
        try {
            file_put_contents( $this->file, '<url><loc>' . $this->generateRoute( $routeName, $routeParams ) . '</loc></url>' . PHP_EOL, FILE_APPEND );
        } catch( \Exception $e ) {
            // we move on, maybe some required route parameter is null
        }
    }

    /**
     * main public site routes
     */
    private function siteRoutes()
    {
        $fileName = 'site_routes.xml';
        $this->file = $this->baseDir . '/' . $fileName;
        $this->clearAndPrepareLinkSet();
        $this->addURLToLinkSet( 'deepmikoto_app_homepage' );
        $this->addURLToLinkSet( 'deepmikoto_app_coding' );
        $this->addURLToLinkSet( 'deepmikoto_app_gaming' );
        $this->addURLToLinkSet( 'deepmikoto_app_photography' );
        $this->addURLToLinkSet( 'deepmikoto_app_help_page' );
        $this->addURLToLinkSet( 'deepmikoto_app_coding_categories' );
        $this->closeLinkSetFile();
        $this->output->writeln('Completed site routes');
    }

    /**
     * @param $type
     * @return null|SiteMapLinkSet
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    private function previousLinkSet( $type )
    {
        return $this->em
            ->getRepository('DeepMikotoApiBundle:SiteMapLinkSet')
            ->createQueryBuilder('ls')
            ->select('ls')
            ->where('ls.type = :type')
            ->setParameter('type', $type)
            ->orderBy('ls.updatedAt', 'DESC')
            ->setMaxResults( 1 )
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    /**
     * @param bool|false|\DateTime $dateScope
     * @param null $firstReferenceId
     * @return array
     */
    private function newCodingPost( $dateScope = false, $firstReferenceId = null )
    {
        $allResults = [];
        $limit = 200;
        do {
            $userProfilesQuery = $this->em
                ->getRepository('DeepMikotoApiBundle:CodingPost')
                ->createQueryBuilder('c')
                ->select('c.id','c.slug')
                ->where('c.public = 1')
                ->orderBy('c.id', 'ASC')
                ->setMaxResults( $limit )
                ->setFirstResult( count($allResults) )
            ;
            if ( !$this->firstRun && $dateScope !== null ) {
                $userProfilesQuery
                    ->andWhere('c.date >= :dateScope')
                    ->setParameter('dateScope', $dateScope === false ? $this->oneWeekAgo : $dateScope )
                ;
                if ( $firstReferenceId != null ) {
                    $userProfilesQuery
                        ->andWhere('c.id >= :firstReferenceId')
                        ->setParameter('firstReferenceId', $firstReferenceId)
                    ;
                }
            }
            $partialResults = $userProfilesQuery->getQuery()->getResult();
            $resultsCount = count( $partialResults );
            $allResults = array_merge( $allResults, $partialResults );
        } while (  $resultsCount == $limit );

        return $allResults;
    }

    /**
     * @param bool|false|\DateTime $dateScope
     * @param null $firstReferenceId
     * @return array
     */
    private function newGamingPosts( $dateScope = false, $firstReferenceId = null )
    {
        $allResults = [];
        $limit = 200;
        do {
            $userProfilesQuery = $this->em
                ->getRepository('DeepMikotoApiBundle:GamingPost')
                ->createQueryBuilder('c')
                ->select('c.id','c.slug')
                ->where('c.public = 1')
                ->orderBy('c.id', 'ASC')
                ->setMaxResults( $limit )
                ->setFirstResult( count($allResults) )
            ;
            if ( !$this->firstRun && $dateScope !== null ) {
                $userProfilesQuery
                    ->andWhere('c.date >= :dateScope')
                    ->setParameter('dateScope', $dateScope === false ? $this->oneWeekAgo : $dateScope )
                ;
                if ( $firstReferenceId != null ) {
                    $userProfilesQuery
                        ->andWhere('c.id >= :firstReferenceId')
                        ->setParameter('firstReferenceId', $firstReferenceId)
                    ;
                }
            }
            $partialResults = $userProfilesQuery->getQuery()->getResult();
            $resultsCount = count( $partialResults );
            $allResults = array_merge( $allResults, $partialResults );
        } while (  $resultsCount == $limit );

        return $allResults;
    }

    /**
     * @param bool|false|\DateTime $dateScope
     * @param null $firstReferenceId
     * @return array
     */
    private function newPhotographyPosts( $dateScope = false, $firstReferenceId = null )
    {
        $allResults = [];
        $limit = 200;
        do {
            $userProfilesQuery = $this->em
                ->getRepository('DeepMikotoApiBundle:PhotographyPost')
                ->createQueryBuilder('c')
                ->select('c.id','c.slug')
                ->where('c.public = 1')
                ->orderBy('c.id', 'ASC')
                ->setMaxResults( $limit )
                ->setFirstResult( count($allResults) )
            ;
            if ( !$this->firstRun && $dateScope !== null ) {
                $userProfilesQuery
                    ->andWhere('c.date >= :dateScope')
                    ->setParameter('dateScope', $dateScope === false ? $this->oneWeekAgo : $dateScope )
                ;
                if ( $firstReferenceId != null ) {
                    $userProfilesQuery
                        ->andWhere('c.id >= :firstReferenceId')
                        ->setParameter('firstReferenceId', $firstReferenceId)
                    ;
                }
            }
            $partialResults = $userProfilesQuery->getQuery()->getResult();
            $resultsCount = count( $partialResults );
            $allResults = array_merge( $allResults, $partialResults );
        } while (  $resultsCount == $limit );

        return $allResults;
    }

    /**
     * @param bool|false|\DateTime $dateScope
     * @param null $firstReferenceId
     * @return array
     */
    private function newCodingCategories( $dateScope = false, $firstReferenceId = null )
    {
        $allResults = [];
        $limit = 200;
        do {
            $userProfilesQuery = $this->em
                ->getRepository('DeepMikotoApiBundle:CodingCategory')
                ->createQueryBuilder('c')
                ->select('c.id', 'c.slug')
                ->orderBy('c.id', 'ASC')
                ->setMaxResults( $limit )
                ->setFirstResult( count($allResults) )
            ;
            if ( !$this->firstRun && $dateScope !== null ) {
                $userProfilesQuery
                    ->where('c.created >= :dateScope')
                    ->setParameter('dateScope', $dateScope === false ? $this->oneWeekAgo : $dateScope )
                ;
                if ( $firstReferenceId != null ) {
                    $userProfilesQuery
                        ->andWhere('c.id >= :firstReferenceId')
                        ->setParameter('firstReferenceId', $firstReferenceId)
                    ;
                }
            }
            $partialResults = $userProfilesQuery->getQuery()->getResult();
            $resultsCount = count( $partialResults );
            $allResults = array_merge( $allResults, $partialResults );
        } while (  $resultsCount == $limit );

        return $allResults;
    }

    /**
     * all routes for coding post pages
     */
    private function codingPostsRoutes()
    {
        $this->findNewEntriesAndUpdateLinkSet( SiteMapLinkSet::CODING_POST_TYPE, 'newCodingPost',
            function(){
                return 'deepmikoto_app_coding_post';
            },
            function( $post ){
                return [ 'id' => $post['id'], 'slug' => $post['slug'] ];
            }
        );
        $this->output->writeln('Completed coding posts routes');
    }

    /**
     * all routes for gaming posts
     */
    private function gamingPostsRoutes()
    {
        $this->findNewEntriesAndUpdateLinkSet( SiteMapLinkSet::GAMING_POST_TYPE, 'newGamingPosts',
            function(){
                return 'deepmikoto_app_gaming_post';
            },
            function( $post ){
                return [ 'id' => $post['id'], 'slug' => $post['slug'] ];
            }
        );
        $this->output->writeln('Completed gaming posts routes');
    }

    /**
     * all routes for photography posts
     */
    private function photographyPostsRoutes()
    {
        $this->findNewEntriesAndUpdateLinkSet( SiteMapLinkSet::PHOTOGRAPHY_POST_TYPE, 'newPhotographyPosts',
            function(){
                return 'deepmikoto_app_photography_post';
            },
            function( $post ){
                return [ 'id' => $post['id'], 'slug' => $post['slug'] ];
            }
        );
        $this->output->writeln('Completed photography post routes');
    }

    /**
     * all routes for coding categories
     */
    private function codingCategoriesRoutes()
    {
        $this->findNewEntriesAndUpdateLinkSet( SiteMapLinkSet::CODING_CATEGORY_TYPE, 'newCodingCategories',
            function(){
                return 'deepmikoto_app_coding_posts_by_category';
            },
            function( $post ){
                return [ 'category' => $post['slug'] ];
            }
        );
        $this->output->writeln('Completed coding categories routes');
    }

    /**
     * @param $type
     * @param callable $newEntriesAction
     * @param callable $routeNameCallback
     * @param callable $routeParamsCallback
     */
    private function findNewEntriesAndUpdateLinkSet( $type, $newEntriesAction, $routeNameCallback, $routeParamsCallback )
    {
        $linkSetEntity = $this->previousLinkSet( $type );
        $addedLinks = 0;
        if ( $linkSetEntity == null || $linkSetEntity->getLinkCount() >= $this->linkSetLimit ){
            $linkSetEntity = new SiteMapLinkSet( $type );
        }
        if ( $linkSetEntity->getId() == null ) {
            $fileName = $linkSetEntity->getType() . '.xml';
            $linkSetEntity->setName( $fileName );

            $newEntries = $this->$newEntriesAction();
        } else {
            $fileName = $linkSetEntity->getName();
            $newEntries = $this->$newEntriesAction( $linkSetEntity->getDateScope(), $linkSetEntity->getFirstReferenceId() );
        }
        if ( !empty( $newEntries ) ) {
            $linkSetEntity->setFirstReferenceId( $newEntries[0]['id'] );
            $this->em->persist( $linkSetEntity );
            $this->file = $this->baseDir . '/' . $fileName;
            $this->clearAndPrepareLinkSet();
            $completedCycles = 0;
            foreach ( $newEntries as $entry ) {
                if ( $addedLinks == $this->linkSetLimit ) {
                    $completedCycles++;
                    $this->closeLinkSetFile();
                    $linkSetEntity->setLinkCount( $addedLinks );
                    $addedLinks = 0;
                    if ( $linkSetEntity->getId() == null ) {
                        $fileName = $linkSetEntity->getType() . '_' . $completedCycles . '.xml';
                    } else {
                        $completedCycles--;
                        $fileName = $linkSetEntity->getType() . '.xml';
                    }
                    $linkSetEntity = new SiteMapLinkSet( $type );
                    $linkSetEntity
                        ->setName( $fileName )
                        ->setFirstReferenceId( $entry['id'] )
                        ->setDateScope( $this->oneWeekAgo )
                    ;
                    $this->em->persist( $linkSetEntity );
                    $this->file = $this->baseDir . '/' . $fileName;
                    $this->clearAndPrepareLinkSet();
                }
                $this->addURLToLinkSet( $routeNameCallback( $entry ), $routeParamsCallback( $entry ) );
                $addedLinks++;
            }
            $this->closeLinkSetFile();
            $linkSetEntity->setLinkCount( $addedLinks );
            $this->em->flush();
        }
    }

    /**
     * remove all previous files and entities if it's the first run
     */
    private function cleanupIfNecessary()
    {
        if ( $this->firstRun ) {
            /** @var SiteMapLinkSet $linkSet */
            foreach( $this->em->getRepository('DeepMikotoApiBundle:SiteMapLinkSet')->findAll() as $linkSet ) {
                $fileName = $this->baseDir . '/' . $linkSet->getName();
                if ( file_exists( $fileName ) && is_file( $fileName ) ) {
                    unlink( $fileName );
                }
                $this->em->remove( $linkSet );
            }
            $this->em->flush();
        }
    }

    /**
     * @param callable $function
     */
    private function generateLinkSet( $function )
    {
        if ( method_exists( $this, $function ) ) {
            if ( false/*!WINDOWS_OS*/ ) {
                $pid = pcntl_fork();
                $this->childPIDs[] = $pid;
                if ($pid == 0) {
                    $this->$function();
                    exit(0);
                }
            } else {
                $this->$function();
            }
            gc_collect_cycles();
        }
    }

    /**
     *
     */
    private function waitForChildServicesToFinish()
    {
        if ( false/*!WINDOWS_OS*/ ) {
            $this->output->writeln('<info>Waiting for child processes to end</info>');
            while ( count( $this->childPIDs ) > 0 ) {
                foreach ( $this->childPIDs as $key => $pid ) {
                    $res = pcntl_waitpid( $pid, $status, WNOHANG );
                    if ( $res == -1 || $res > 0 ) {
                        unset( $this->childPIDs[$key] );
                    }
                }
                sleep(5);
            }
            $this->output->writeln('<info>Child processes finished</info>');
        }
    }

    /**
     *  write xml link set definition tags
     */
    private function clearAndPrepareLinkSet()
    {
        if( file_exists( $this->file ) ){ // clear file if it exists
            $fp = fopen( $this->file, "r+" );
            ftruncate( $fp, 0 );
            fclose( $fp );
        }

        file_put_contents( $this->file, '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL, FILE_APPEND );
        file_put_contents( $this->file, '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 ' . 'http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">'.PHP_EOL, FILE_APPEND);
    }

    /**
     * write xml link set closing tag
     */
    private function closeLinkSetFile()
    {
        file_put_contents( $this->file, '</urlset>' . PHP_EOL, FILE_APPEND );
    }

    /**
     * include all link sets to main sitemap.xml file
     */
    private function generateSiteMapIndex()
    {
        $this->file = $this->baseDir . '.xml';
        if( file_exists( $this->file ) ) { // empty the file if it exists
            $fp = fopen( $this->file, "r+" );
            ftruncate( $fp, 0 );
            fclose( $fp );
        }
        file_put_contents($this->file, '<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL,FILE_APPEND);
        file_put_contents($this->file, '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'.PHP_EOL,FILE_APPEND);
        $url = $this->siteScheme.'://'.$this->siteName.'/sitemap/';
        $sitemapList = ['site_routes.xml'];
        $sitemapList = array_merge(
            $sitemapList,
            $this->em->getRepository('DeepMikotoApiBundle:SiteMapLinkSet')->findBy([ 'type' => SiteMapLinkSet::CODING_POST_TYPE ], [ 'updatedAt' => 'ASC' ] ),
            $this->em->getRepository('DeepMikotoApiBundle:SiteMapLinkSet')->findBy([ 'type' => SiteMapLinkSet::GAMING_POST_TYPE ], [ 'updatedAt' => 'ASC' ] ),
            $this->em->getRepository('DeepMikotoApiBundle:SiteMapLinkSet')->findBy([ 'type' => SiteMapLinkSet::PHOTOGRAPHY_POST_TYPE ], [ 'updatedAt' => 'ASC' ] ),
            $this->em->getRepository('DeepMikotoApiBundle:SiteMapLinkSet')->findBy([ 'type' => SiteMapLinkSet::CODING_CATEGORY_TYPE ], [ 'updatedAt' => 'ASC' ] )
        );
        /** @var SiteMapLinkSet|string $sitemap */
        foreach( $sitemapList as $sitemap ){
            file_put_contents(
                $this->file,
                '<sitemap><loc>' . $url . ( $sitemap instanceof SiteMapLinkSet ? $sitemap->getName() : $sitemap ) . '</loc><lastmod>' . date( 'c', ( $sitemap instanceof SiteMapLinkSet ? $sitemap->getUpdatedAt()->getTimestamp() : time() ) ) . '</lastmod></sitemap>' . PHP_EOL,
                FILE_APPEND
            );
        }
        file_put_contents($this->file, '</sitemapindex>'.PHP_EOL,FILE_APPEND);
    }
}

