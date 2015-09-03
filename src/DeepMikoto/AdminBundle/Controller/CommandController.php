<?php
/**
 * Created by PhpStorm.
 * User: MiKoRiza-OnE
 * Date: 7/28/2015
 * Time: 06:49
 */

namespace DeepMikoto\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\HttpFoundation\Response;

/**
 * used for executing symfony commands from controller
 *
 * Class CommandController
 * @package DeepMikoto\AdminBundle\Controller
 */
class CommandController extends Controller
{
    /**
     * clear the production cache
     *
     * @return Response
     * @throws \Exception
     */
    public function cacheClearAction()
    {
        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN', null, 'Unable to access this page!');
        /** @var \Symfony\Component\HttpKernel\KernelInterface $kernel */
        $kernel = $this->get( 'kernel' );
        $application = new Application( $kernel );
        $application->setAutoExit( false );
        $input = new ArrayInput([
            'command' => 'cache:clear',
            '--env'   => 'prod'
        ]);
        $output = new NullOutput();
        $application->run( $input, $output );

        return new Response( 'Cache cleared!', 200 );
    }

    /**
     * install assets
     *
     * @return Response
     * @throws \Exception
     */
    public function assetsInstallAction()
    {
        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN', null, 'Unable to access this page!');
        /** @var \Symfony\Component\HttpKernel\KernelInterface $kernel */
        $kernel = $this->get( 'kernel' );
        $application = new Application( $kernel );
        $application->setAutoExit( false );
        $input = new ArrayInput([
            'command' => 'assets:install'
        ]);
        $output = new NullOutput();
        $application->run( $input, $output );

        return new Response( 'Assets installed!', 200 );
    }

    /**
     * minify assets
     *
     * @return Response
     * @throws \Exception
     */
    public function asseticDumpAction()
    {
        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN', null, 'Unable to access this page!');
        /** @var \Symfony\Component\HttpKernel\KernelInterface $kernel */
        $kernel = $this->get( 'kernel' );
        $application = new Application( $kernel );
        $application->setAutoExit( false );
        $input = new ArrayInput([
            'command' => 'assetic:dump',
            '--env'   => 'prod'
        ]);
        $output = new NullOutput();
        $application->run( $input, $output );

        return new Response( 'Assets dumped!', 200 );
    }

    /**
     * fetch latest code from GIT
     *
     * @return Response
     * @throws \Exception
     */
    public function gitPullMasterAction()
    {
        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN', null, 'Unable to access this page!');
        /** @var \Symfony\Component\HttpKernel\KernelInterface $kernel */
        $kernel = $this->get( 'kernel' );
        $application = new Application( $kernel );
        $application->setAutoExit( false );
        $input = new ArrayInput([
            'command' => 'git pull origin develop'
        ]);
        $output = new NullOutput();
        $application->run( $input, $output );

        return new Response( 'Code updated!', 200 );
    }

    /**
     * install composer dependencies
     *
     * @return Response
     * @throws \Exception
     */
    public function composerInstallAction()
    {
        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN', null, 'Unable to access this page!');
        /** @var \Symfony\Component\HttpKernel\KernelInterface $kernel */
        $kernel = $this->get( 'kernel' );
        $application = new Application( $kernel );
        $application->setAutoExit( false );
        $input = new ArrayInput([
            'command' => 'composer install'
        ]);
        $output = new NullOutput();
        $application->run( $input, $output );

        return new Response( 'Dependencies installed', 200 );
    }

    /**
     * execute latest Doctrine migrations
     *
     * @return Response
     * @throws \Exception
     */
    public function migrationsMigrateAction()
    {
        $this->denyAccessUnlessGranted('ROLE_SUPER_ADMIN', null, 'Unable to access this page!');
        /** @var \Symfony\Component\HttpKernel\KernelInterface $kernel */
        $kernel = $this->get( 'kernel' );
        $application = new Application( $kernel );
        $application->setAutoExit( false );
        $input = new ArrayInput([
            'command' => 'doctrine:migrations:migrate',
            '--no-interaction'
        ]);
        $output = new NullOutput();
        $application->run( $input, $output );

        return new Response( 'Migrations executed!', 200 );
    }
}