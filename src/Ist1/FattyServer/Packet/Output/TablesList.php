<?php

namespace FattyServer\Packet\Output;

use FattyServer\FattyServerProtocol;
use FattyServer\Player\Player;
use FattyServer\Table\Table;


class TablesList extends AbstractListOutputPacket
{
    /**
     * @param Table $table
     * @return array
     */
    public function getItemData($table)
    {
        $players = array();

        foreach ($table->getPlayers()->getAll() as $conn) {
            /** @var Player $player */
            $player = $table->getPlayers()->getOne($conn);
            $players[] = array(
                'player_id' => $player->getId(),
                'is_ready' => $player->isReady()
            );
        }

        return array(
            'table_id' => $table->getId(),
            'name' => $table->getName(),
            'players' => $players
        );
    }

    /**
     * @return int
     */
    public function getType()
    {
        return FattyServerProtocol::PACKET_TABLES_LIST;
    }

    /**
     * @return bool
     */
    public function isDataStorage()
    {
        return false;
    }
} 