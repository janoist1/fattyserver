<?php

namespace FattyServer\Packet\Output;

use FattyServer\Card\Dealer;
use FattyServer\FattyServerProtocol;
use FattyServer\Packet\Output\PlayersList\AbstractPlayersList;
use FattyServer\Player\Player;
use FattyServer\Table\Table;


class SwapDone extends AbstractPlayerOutputPacket
{
    /**
     * @return int
     */
    public function getType()
    {
        return FattyServerProtocol::PACKET_SWAP_DONE;
    }
} 