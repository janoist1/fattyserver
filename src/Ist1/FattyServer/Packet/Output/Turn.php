<?php

namespace FattyServer\Packet\Output;

use FattyServer\FattyServerProtocol;
use FattyServer\Player\Player;


class Turn extends AbstractPlayerOutputPacket
{
    /**
     * @var array
     */
    protected $cardsPut;

    /**
     * @var array
     */
    protected $cardsPick;

    /**
     * @var bool
     */
    protected $burn;

    /**
     * @param Player $player
     * @param array $cardsPut
     * @param array $cardsPick
     * @param bool $burn
     */
    function __construct(Player $player, array $cardsPut, array $cardsPick, $burn)
    {
        parent::__construct($player);

        $this->cardsPut = $cardsPut;
        $this->cardsPick = $cardsPick;
        $this->burn = $burn;
    }

    /**
     * @return array
     */
    public function getData()
    {
        $data = array(
            'cards_put' => $this->cardsPut,
            'cards_pick' => $this->cardsPick,
            'burn' => $this->burn,
        );

        return array_merge(parent::getData(), $data);
    }

    /**
     * @return int
     */
    public function getType()
    {
        return FattyServerProtocol::PACKET_TURN;
    }
} 