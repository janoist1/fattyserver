<?php

namespace FattyServer\Packet\Output;

use FattyServer\FattyServerProtocol;
use FattyServer\Table\Table;


class Gathering extends AbstractTableOutputPacket
{
    /**
     * @return int
     */
    public function getType()
    {
        return FattyServerProtocol::MSG_GATHERING;
    }
} 