<?php

namespace FattyServer\Packet\Output\PlayersList;

use FattyServer\FattyServerProtocol;
use FattyServer\Player\Player;


class TablePlayersList extends AbstractPlayersList
{
    /**
     * @param Player $table
     * @return array
     */
    public function getItemData($table)
    {
        return array(
            'id' => $table->getId(),
        );
    }

    /**
     * @return int
     */
    public function getType()
    {
        return FattyServerProtocol::MSG_TABLE_PLAYERS_LIST;
    }
} 