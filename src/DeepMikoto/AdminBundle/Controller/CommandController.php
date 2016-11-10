<?php
/**
 * Created by PhpStorm.
 * User: MiKoRiza-OnE
 * Date: 7/28/2015
 * Time: 06:49
 */

namespace DeepMikoto\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Process\Process;

/**
 * used for executing symfony commands from controller
 *
 * Class CommandController
 * @package DeepMikoto\AdminBundle\Controller
 */
class CommandController extends Controller
{
    private $commands;

    public function __construct()
    {
        $this->commands = [
            'git-pull-master' => 'git pull origin master',
            'composer-install' => 'php composer.phar install',
            'cache-clear' => 'php bin/console cache:clear --env=prod',
            'migrations-migrate' => 'php bin/console doctrine:migrations:migrate --no-interaction',
            'assets-install' => 'php bin/console assets:install --symlink',
            'assetic-dump' => 'php bin/console assetic:dump --env=prod'
        ];
    }

    private function getCommand( $name )
    {
        $command = null;
        if( is_string( $name ) && array_key_exists( $name, $this->commands ) ){
            return $this->commands[ $name ];
        }

        return $command;
    }

    /**
     * @param array $commands
     * @return StreamedResponse
     */
    private function executeCommands( $commands = [] )
    {
        $path = $this->get('kernel')->getRootDir()  . '/../';
        $response =  new StreamedResponse( function() use ( $path, $commands ){
            echo $this->renderView( 'DeepMikotoAdminBundle:Parts:command_template.html.twig' );
            foreach( $commands as $command ){
                echo '<span class="command"> -> ' . $command . '</span>';
                echo '<script>window.scrollTo(0,document.body.scrollHeight)</script>';
                $process = new Process( $command, $path );
                $process->run(function ($type, $buffer) {
                    if (Process::ERR === $type) {
                        echo '<span class="text-danger">' . $buffer . '</span>';
                        echo '<script>window.scrollTo(0,document.body.scrollHeight)</script>';
                    } else {
                        echo '<span>' . $buffer . '</span>';
                        echo '<script>window.scrollTo(0,document.body.scrollHeight)</script>';
                    }
                    ob_flush();
                    flush();
                });
            }
            echo '<br><span>Done!</span><br>';
            echo '<button type="button" class="button" onclick="window.close();">close window</button>';
            echo '<script>window.scrollTo(0,document.body.scrollHeight)</script>';
        });

        return $response;
    }

    public function executeAction( $commandArray )
    {
        set_time_limit(0);
        $commandArray = json_decode( $commandArray );
        if( is_array( $commandArray ) && count( $commandArray ) > 0 ){
            $commands = [];
            foreach( $commandArray as $commandName ){
                $command = $this->getCommand( $commandName );
                $command != null ? $commands[] = $command : null;
            }
            if( count( $commands ) > 0 ){
                return $this->executeCommands( $commands );
            }
        }

        return $this->render( 'DeepMikotoAdminBundle:Parts:command_template.html.twig', [ 'exception' => 'nothing to execute ...' ] );

    }
}