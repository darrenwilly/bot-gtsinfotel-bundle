<?php
declare(strict_types=1);

namespace Veiw\BotVAS\GTSInfoTel\Channel;

use Veiw\BotLogic\Core\ServiceProvider\ServiceProviderChannelInterface;

class ShortcodeOptions implements ServiceProviderChannelInterface
{
    protected $toIdentifier = 'to';
    protected $fromIdentifier = 'from';
    protected $contentIdentifier = 'text';


    public function getChannelName()
    {
        return CHANNEL_SMS_SHORTCODE ;
    }
    public function getServiceProviderName()
    {
        return SERVICE_PROVIDER_GTSINFOTEL ;
    }

    public function getContentKeyIdentifier()
    {
        return $this->contentIdentifier;
    }

    public function getFromKeyIdentifier()
    {
        return $this->fromIdentifier ;
    }

    public function getToKeyIdentifier()
    {
        return $this->toIdentifier;
    }
}