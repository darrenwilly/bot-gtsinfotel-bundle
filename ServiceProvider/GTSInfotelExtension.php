<?php
declare(strict_types=1);

namespace Veiw\BotVAS\GTSInfoTel\ServiceProvider;

use Veiw\BotLogic\Core\ServiceProvider\ServiceProviderExtensionInterface;

class GTSInfotelExtension implements ServiceProviderExtensionInterface
{
    protected $name = 'gtsinfotel' ;
    protected $channel ;
    protected $requestType ;

    public function __construct($options=[])
    {
        $this->getSupportedChannel() ;
        $this->requestType = 'get' ;
    }

    public function getName()
    {
        return SERVICE_PROVIDER_GTSINFOTEL ;
    }

    public function getSupportedChannel()
    {
        $channel = [
            CHANNEL_SMS_SHORTCODE
        ] ;
        ##
        $this->channel = $channel ;
    }

    public function hasChannel($channelAlias)
    {
        return isset($this->channel[$channelAlias]) ;
    }

    public function getChannel($channelAlias)
    {
       return $this->channel[$channelAlias] ;
    }

    public function getRequestType()
    {
        return $this->requestType ;
    }
}