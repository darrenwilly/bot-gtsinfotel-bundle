<?php

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator ;

if(isset($container) && (! $container instanceof \Symfony\Component\DependencyInjection\ContainerBuilder) )   {
    trigger_error('invalid container object') ;
    die;
}


/**
 * register the Container
 */
return function(ContainerConfigurator $configurator) use($container) {
    // default configuration for services in *this* file
    $services = $configurator->services();
    /**
     *
     */
    $services->defaults()
        ->autowire()      // Automatically injects dependencies in your services.
        ->autoconfigure() // Automatically registers your services as commands, event subscribers, etc.
        ->public()
    ;

    $parameters = $configurator->parameters();

    try{
        /**
         * Point to call default symfony service to made public
         */
        ## autoload the extra configuration for the module
        #$configurator->import(__DIR__.'/autoload/*.php');
        ## set the parameters
        $parameters->set('bot-gtsinfotel.bundle.dir', dirname(dirname(__DIR__)));

        $parameters->set('GTSINFOTEL_SMS_MT_ENDPOINT' , '%env(GTSINFOTEL_SMS_MT_ENDPOINT)%');
        $parameters->set('GTSINFOTEL_HOST' , '%env(GTSINFOTEL_HOST)%');
        $parameters->set('GTSINFOTEL_PORT' , '%env(GTSINFOTEL_PORT)%');
        $parameters->set('GTSINFOTEL_USERNAME' , '%env(GTSINFOTEL_USERNAME)%');
        $parameters->set('GTSINFOTEL_PASSWORD' , '%env(GTSINFOTEL_PASSWORD)%');
        $parameters->set('GTSINFOTEL_SHORTCODE' , '%env(GTSINFOTEL_SHORTCODE)%');
        $parameters->set('GTSINFOTEL_ACCOUNT_NAME' , '%env(GTSINFOTEL_ACCOUNT_NAME)%');


        ## create a service that bare the name of the service provider bac.channel_adapter.options
        $services->set(\Veiw\BotVAS\GTSInfoTel\Channel\ShortcodeOptions::class)->tag(\Veiw\BotLogic\Core\Channel\ChannelAdapterAggregator::SERVICE_TAG_ALIAS) ;
        $services->set(\Veiw\BotVAS\GTSInfoTel\ServiceProvider\GTSInfotelExtension::class)->tag(\Veiw\BotLogic\Core\ServiceProvider\ServiceProviderAggregator::SERVICE_TAG_ALIAS) ;
        $services->set(\Veiw\BotVAS\GTSInfoTel\Response\ShortcodeResponse::class)->tag(\Veiw\BotLogic\Core\ServiceProvider\ServiceProviderResponseAggregator::SERVICE_TAG_ALIAS) ;

        /**
         * LOAD Validator

        $services->load('Veiw\\BotVAS\\GTSInfotel\\ValidatorConstraint\\' , APPLICATION_PATH.'/core-source/Core/ValidatorConstraint/*')
                    ->tag('validator.constraint_validator') ;*/


    }
    catch (\Throwable $exception)   {
        ##
        dump($exception);exit;
    }
    ##
    return $services;
};
