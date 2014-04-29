<?php

namespace FattyServer\Handler;

use FattyServer\Handler\Packet\AbstractPacketHandler;
use FattyServer\Packet\Output\PlayerLeft;


class PlayerLeftHandler extends AbstractPacketHandler
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

        $this->propagator->sendPacketToAll(new PlayerLeft($player));

        if ($table != null && !$table->isPlayerActive($player)) {
            $table->playerLeft($player);

            if ($player == $table->getCurrentPlayer()) {
                // todo: make a turn instead of the Player
            }
        }
    }
} 