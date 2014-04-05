<?php

namespace FattyServer\Packet\Output;

use FattyServer\FattyServerProtocol;
use FattyServer\Player\Player;


class NewPlayer extends AbstractOutputPacket
{
    /**
     * @var Player
     */
    protected $player;

    /**
     * @param Player $player
     */
    function __construct(Player $player)
    {
        $this->player = $player;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return array(
            'id' => $this->player->getId(),
            'name' => $this->player->getName()
        );
    }

    /**
     * @return int
     */
    public function getType()
    {
        return FattyServerProtocol::MSG_NEW_PLAYER;
    }
}