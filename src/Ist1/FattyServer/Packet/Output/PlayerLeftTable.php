<?php

namespace FattyServer\Packet\Output;

use FattyServer\FattyServerProtocol;
use FattyServer\Player\Player;


class PlayerLeftTable extends AbstractPlayerOutputPacket
{
    /**
     * @return int
     */
    public function getType()
    {
        return FattyServerProtocol::MSG_PLAYER_LEFT_TABLE;
    }
} 