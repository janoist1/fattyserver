<?php

namespace FattyServer\Packet\Output\PlayersList;

use FattyServer\FattyServerProtocol;
use FattyServer\Player\Player;


class PlayersList extends AbstractPlayersList
{
    /**
     * @param Player $player
     * @return array
     */
    public function getItemData($player)
    {
        return array(
            'player_id' => $player->getId(),
            'name' => $player->getName(),
        );
    }

    /**
     * @return int
     */
    public function getType()
    {
        return FattyServerProtocol::MSG_PLAYERS_LIST;
    }
} 