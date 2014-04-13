<?php

namespace FattyServer\Packet\Output;

use FattyServer\FattyServerProtocol;
use FattyServer\Player\Player;


class PlayerLeft extends AbstractPlayerOutputPacket
{
    /**
     * @return int
     */
    public function getType()
    {
        return FattyServerProtocol::MSG_PLAYER_LEFT;
    }
} 