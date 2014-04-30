<?php

namespace FattyServer\Packet\Output;

use FattyServer\FattyServerProtocol;
use FattyServer\Player\Player;
use FattyServer\Table\Table;


class NewTable extends AbstractTableOutputPacket
{
    /**
     * @return array
     */
    public function getData()
    {
        $data = array(
            'name' => $this->table->getName(),
            'is_ready' => false,
            'players' => array(),
        );

        return array_merge(parent::getData(), $data);
    }

    /**
     * @return int
     */
    public function getType()
    {
        return FattyServerProtocol::MSG_NEW_TABLE;
    }
} 