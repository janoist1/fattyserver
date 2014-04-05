<?php

namespace FattyServer\Packet\Output;

use FattyServer\FattyServerProtocol;
use FattyServer\Player\Player;


class PlayersList extends AbstractListOutputPacket
{
    /**
     * @param Player $table
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
        return FattyServerProtocol::MSG_PLAYERS_LIST;
    }

    /**
     * @return bool
     */
    public function isDataStorage()
    {
        return true;
    }
} 