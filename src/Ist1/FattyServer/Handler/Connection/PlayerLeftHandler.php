<?php

namespace FattyServer\Handler\Connection;

use FattyServer\Packet\Output\PlayerLeft;


class PlayerLeftHandler extends AbstractConnectionHandler
{
    /**
     * Removes a player and let others know about it.
     */
    public function handle()
    {
        $player = $this->playerManager->getPlayers()->getOne($this->connection);
        $table = $this->tableManager->getTableByPlayer($player);

        $player->setConnected(false);
        $this->playerManager->getPlayers()->remove($player);

        $this->propagator->sendPacket(new PlayerLeft($player));

        if ($table != null && !$table->isPlayerLeft($player)) {
            $this->playerLeft($player, $table);

            if ($player == $table->getActivePlayer()) {
                // todo: make a turn instead of the Player
            }
        }
    }
} 