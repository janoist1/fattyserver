<?php

namespace FattyServer\Packet\Output;

use FattyServer\FattyServerProtocol;
use FattyServer\Player\Player;


class NewPlayer extends AbstractPlayerOutputPacket
{
    /**
     * @return array
     */
    public function getData()
    {
        $data = array(
            'name' => $this->player->getName(),
            'is_ready' => false,
        );

        return array_merge(parent::getData(), $data);
    }

    /**
     * @return int
     */
    public function getType()
    {
        return FattyServerProtocol::PACKET_NEW_PLAYER;
    }
}