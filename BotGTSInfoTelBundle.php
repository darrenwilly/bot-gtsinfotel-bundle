<?php
declare(strict_types=1) ;

namespace Veiw\BotVAS\GTSInfoTel;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Veiw\BotVAS\GTSInfoTel\DependencyInjection\BotGTSInfoTelExtension;


class BotGTSInfoTelBundle extends Bundle
{

    public function boot()
    {
        ## load the bootstrap file
        $bootstrap = __DIR__ . '/bootstrap.php';
        ##
        if(! file_exists($bootstrap))    {
            throw new \RuntimeException('bootstrap file is required to initialized the Bundle for interopability purpose') ;
        }
        ##
        require $bootstrap ;

        parent::boot() ;
    }

    public function build(ContainerBuilder $container)
    {
        parent::build($container) ;
    }

    public function getContainerExtension()
    {
        return new BotGTSInfoTelExtension() ;
    }

    public function shutdown()
    {
    }

}