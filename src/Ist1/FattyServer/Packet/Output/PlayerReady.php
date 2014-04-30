<?php

namespace FattyServer\Packet\Output;

use FattyServer\FattyServerProtocol;
use FattyServer\Player\Player;


class PlayerReady extends AbstractPlayerOutputPacket
{
    /**
     * @return int
     */
    public function getType()
    {
        return FattyServerProtocol::PACKET_PLAYER_READY;
    }
} 