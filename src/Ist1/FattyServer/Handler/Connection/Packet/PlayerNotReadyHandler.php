<?php

namespace FattyServer\Handler\Connection\Packet;

use FattyServer\Handler\AbstractHandler;
use FattyServer\Handler\Connection\AbstractConnectionHandler;
use FattyServer\Packet\Output\PlayerNotReady;


class PlayerNotReadyHandler extends AbstractConnectionHandler
{
    /**
     * Handles ReadyNotPlayer request.
     * Propagates it to all other Players.
     */
    public function handle()
    {
        $player = $this->playerManager->getPlayers()->getOne($this->connection);
        $table = $this->tableManager->getTableByPlayer($player);

        if ($table == null) {
            // todo: handle Player is not at this Table
            return;
        }
        if (!$player->isReady()) {
            // todo: handle Player is not ready yet
            return;
        }
        if ($table->isReady()) {
            // todo: handle Table is already ready, can't "unready"
            return;
        }

        $player->setReady(false);

        $this->propagator->sendPacket(new PlayerNotReady($player));
    }
}