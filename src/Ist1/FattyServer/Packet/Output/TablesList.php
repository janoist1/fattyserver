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
        $playerIds = array();

        foreach ($table->getPlayers()->getAll() as $conn) {
            /** @var Player $player */
            $player = $table->getPlayers()->getOne($conn);
            $playerIds[] = $player->getId();
        }

        return array(
            'table_id' => $table->getId(),
            'name' => $table->getName(),
            'player_ids' => $playerIds,
            'is_ready' => $table->isReady(),
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