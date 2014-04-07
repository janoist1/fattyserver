<?php

namespace FattyServer\Packet\Output;

use FattyServer\Player\Player;


abstract class AbstractPlayerOutputPacket extends AbstractOutputPacket
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
            'player_id' => $this->player->getId()
        );
    }
}