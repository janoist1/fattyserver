<?php

namespace FattyServer\Packet\Output;

use FattyServer\Card\Dealer;
use FattyServer\FattyServerProtocol;
use FattyServer\Player\Player;
use FattyServer\Table\Table;


class Swap extends AbstractOutputPacket
{
    /**
     * @var Player
     */
    protected $player;

    /**
     * @param Player $player
     * @param Table $table
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
            'cards_up' => $this->player->getCardsUp()->getIds(),
        );
    }

    /**
     * @return int
     */
    public function getType()
    {
        return FattyServerProtocol::MSG_SWAP;
    }
} 