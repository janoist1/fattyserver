<?php

namespace FattyServer\Packet\Output;

use FattyServer\FattyServerProtocol;
use FattyServer\Player\Player;


class PutCard extends AbstractPlayerOutputPacket
{
    /**
     * @var array
     */
    protected $cards;

    /**
     * @param Player $player
     * @param array $cards
     */
    function __construct(Player $player, array $cards)
    {
        parent::__construct($player);

        $this->cards = $cards;
    }

    /**
     * @return array
     */
    public function getData()
    {
        $data = array(
            'cards' => $this->cards,
        );

        return array_merge(parent::getData(), $data);
    }

    /**
     * @return int
     */
    public function getType()
    {
        return FattyServerProtocol::MSG_PUT_CARD;
    }
} 