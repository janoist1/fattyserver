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
            'name' => $this->player->getName()
        );

        return array_merge(parent::getData(), $data);
    }

    /**
     * @return int
     */
    public function getType()
    {
        return FattyServerProtocol::MSG_NEW_PLAYER;
    }
}