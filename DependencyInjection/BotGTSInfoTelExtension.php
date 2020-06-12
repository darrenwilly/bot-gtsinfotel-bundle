<?php
declare(strict_types=1);

namespace Veiw\BotVAS\GTSInfoTel\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

/**
 * This is the class that loads and manages DVDoctrineBundle configuration.
 *
 * @author DarrenTrojan <darren.willy@gmail.com>
 */
class BotGTSInfoTelExtension extends Extension implements PrependExtensionInterface
{

    public function prepend(ContainerBuilder $container): void
    {
        ## fetch all the extension
        $extension = $container->getExtensions() ;

    }

    /**
     * {@inheritdoc}
     *
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        try {
            ##
            $locator = new FileLocator(dirname(__DIR__) . '/Resources/config/');
            ##
            $loader = new PhpFileLoader($container, $locator);
            ##
            $loader->load('services.php', 'php');
            ##
            #$loader->load('routes.php' , 'php');

        } catch (\Throwable $exception) {
            #var_dump($exception->getMessage() . '<br>'. $exception->getTraceAsString()); exit;
        }
    }

    public function getAlias()
    {
        return 'BotGTSInfoTel' ;
    }

}
