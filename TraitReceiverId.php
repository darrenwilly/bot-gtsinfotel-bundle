<?php
declare(strict_types=1);

namespace Veiw\BotVAS\GTSInfotel\ServiceProvider ;

trait TraitReceiverId
{
    /**
     * @var string
     */
    protected $receiverId ;

    public function getReceiverId()
    {
        return $this->receiverId ;
    }

    public function setReceiverId($receiverId)
    {
        $this->receiverId = $receiverId ;
    }
}