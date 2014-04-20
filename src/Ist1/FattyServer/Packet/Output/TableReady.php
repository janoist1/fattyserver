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
        return FattyServerProtocol::MSG_TABLE_READY;
    }
} 