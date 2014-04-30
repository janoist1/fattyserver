<?php

namespace FattyServer\Packet\Output;

use FattyServer\FattyServerProtocol;
use FattyServer\Table\Table;


class TableReady extends AbstractTableOutputPacket
{
    /**
     * @return int
     */
    public function getType()
    {
        return FattyServerProtocol::PACKET_TABLE_READY;
    }
} 