<?php

namespace FattyServer\Packet\Output\PlayersList;

use FattyServer\FattyServerProtocol;
use FattyServer\Player\Player;


class TablePlayersList extends AbstractPlayersList
{
    /**
     * @param Player $player
     * @return array
     */
    public function getItemData($player)
    {
        return array(
            'id' => $player->getId(),
            'is_ready' => $player->isReady(),
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