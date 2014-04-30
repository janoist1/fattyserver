<?php

namespace FattyServer\Packet\Output;

use FattyServer\Card\Dealer;
use FattyServer\FattyServerProtocol;
use FattyServer\Player\Player;
use FattyServer\Table\Table;


class Swap extends AbstractPlayerOutputPacket
{
    /**
     * @return array
     */
    public function getData()
    {
        $data = array(
            'cards_up' => $this->player->getCardsUp()->getIds(),
        );

        return array_merge(parent::getData(), $data);
    }

    /**
     * @return int
     */
    public function getType()
    {
        return FattyServerProtocol::PACKET_SWAP;
    }
} 