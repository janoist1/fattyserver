<?php

namespace FattyServer\Packet\Output;

use FattyServer\FattyServerProtocol;
use FattyServer\Player\Player;


class PlayerList extends AbstractOutputPacket
{
    /**
     * @var \SplObjectStorage
     */
    protected $players;

    /**
     * @param \SplObjectStorage $players
     */
    function __construct(\SplObjectStorage $players)
    {
        $this->players = $players;
    }

    /**
     * @return array
     */
    public function getData()
    {
        $data = array();

        /** @var Player $player */
        foreach ($this->players as $conn) {
            $player = $this->players[$conn];
            $data[] = array(
                'id' => $player->getId(),
                'name' => $player->getName(),
            );
        }

        return $data;
    }

    /**
     * @return int
     */
    public function getType()
    {
        return FattyServerProtocol::MSG_PLAYERS_LIST;
    }
} 