<?php

namespace FattyServer\Packet\Output;

use FattyServer\FattyServerProtocol;


class TableReset extends AbstractTableOutputPacket
{
    /**
     * @return int
     */
    public function getType()
    {
        return FattyServerProtocol::PACKET_TABLE_RESET;
    }
} 