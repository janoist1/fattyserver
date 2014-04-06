<?php

namespace FattyServer\Packet\Output;

use FattyServer\FattyServerProtocol;
use FattyServer\Player\Player;


class PlayerReady extends AbstractOutputPacket
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
            'id' => $this->player->getId()
        );
    }

    /**
     * @return int
     */
    public function getType()
    {
        return FattyServerProtocol::MSG_PLAYER_READY;
    }
} 