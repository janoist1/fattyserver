<?php

namespace FattyServer\Handler\Connection\Packet;

use FattyServer\Handler\Connection\AbstractConnectionHandler;
use FattyServer\Packet\Output\PlayerLeftTable;


class PlayerLeftTableHandler extends AbstractConnectionHandler
{
    /**
     * Removes a player from a table and let others know about it.
     */
    public function handle()
    {
        $player = $this->playerManager->getPlayers()->getOne($this->connection);
        $table = $this->tableManager->getTableByPlayer($player);

        if ($table == null) {
            // todo: handle Player not sitting at this Table
            return;
        }
        if ($table->isPlayerLeft($player)) {
            // todo: handle Player already left the Table
            return;
        }

        $player->setReady(false);
        $player->setSwapDone(false);

        $this->propagator->sendPacketToAll(new PlayerLeftTable($player));

        $this->playerLeft($player, $table);

        if ($player == $table->getCurrentPlayer()) {
            // todo: make a turn instead of the Player
        }
    }
} 