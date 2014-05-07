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
            'is_ready' => $player->isReady(),
        );
    }

    /**
     * @return int
     */
    public function getType()
    {
        return FattyServerProtocol::PACKET_PLAYERS_LIST;
    }
} 