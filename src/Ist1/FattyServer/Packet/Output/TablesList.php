<?php

namespace FattyServer\Packet\Output;

use FattyServer\FattyServerProtocol;
use FattyServer\Table\Table;


class TablesList extends AbstractListOutputPacket
{
    /**
     * @param Table $table
     * @return array
     */
    public function getItemData($table)
    {
        return array(
            'id' => $table->getId(),
            'name' => $table->getName(),
        );
    }

    /**
     * @return int
     */
    public function getType()
    {
        return FattyServerProtocol::MSG_TABLES_LIST;
    }

    /**
     * @return bool
     */
    public function isDataStorage()
    {
        return false;
    }
} 