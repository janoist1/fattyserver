<?php

namespace FattyServer\Packet\Output\PlayersList;

use FattyServer\FattyServerProtocol;
use FattyServer\Packet\Output\AbstractListOutputPacket;
use FattyServer\Player\Player;


abstract class AbstractPlayersList extends AbstractListOutputPacket
{
    /**
     * @return bool
     */
    public function isDataStorage()
    {
        return true;
    }
} 