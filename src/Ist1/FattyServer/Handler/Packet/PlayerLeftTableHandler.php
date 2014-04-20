<?php

namespace FattyServer\Handler\Packet;

use FattyServer\Handler\AbstractHandler;
use FattyServer\Packet\Output\PlayerLeftTable;


class PlayerLeftTableHandler extends AbstractHandler
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

        $table->playerLeft($player);
        $player->setReady(false);
        $player->setSwapDone(false);

        $this->propagator->sendPacketToPlayers(new PlayerLeftTable($player));

        if ($player == $table->getCurrentPlayer()) {
            // todo: make a turn instead of the Player
        }
    }
} 