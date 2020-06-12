<?php
declare(strict_types=1);

namespace Veiw\BotVAS\GTSInfotel\ServiceProvider ;


trait TraitSenderId
{

    /**
     * @var string
     */
    protected $senderId ;

    public function getSenderId()
    {
        return $this->senderId ;
    }

    public function setSenderId($senderId)
    {
        $this->senderId = $senderId ;
    }
}