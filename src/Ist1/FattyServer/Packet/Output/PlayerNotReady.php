<?php

namespace FattyServer\Packet\Output;

use FattyServer\FattyServerProtocol;


class PlayerNotReady extends AbstractPlayerOutputPacket
{
    /**
     * @return int
     */
    public function getType()
    {
        return FattyServerProtocol::PACKET_PLAYER_NOT_READY;
    }
} 