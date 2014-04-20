<?php

namespace FattyServer\Handler\Packet;

use FattyServer\FattyConnection;
use FattyServer\Handler\AbstractHandler;
use FattyServer\Packet\Output\GameStart;
use FattyServer\Packet\Output\PlayerReady;
use FattyServer\Packet\Output\TableReady;


class PlayerReadyHandler extends AbstractHandler
{
    /**
     * Handles ReadyPlayer request.
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
        if ($player->isReady()) {
            // todo: handle Player is already ready
            return;
        }

        $player->setReady(true);
        $this->propagator->sendPacketToPlayers(new PlayerReady($player));


        if ($table->isReady()) {
            $this->propagator->sendPacketToPlayers(new TableReady($table));
            $players = clone $table->getPlayers()->getAll();

            $table->getDealer()->deal($players);

            /** @var FattyConnection $conn */
            foreach ($players as $conn) {
                $conn->sendPacket(new GameStart($players->offsetGet($conn), $table));
            }
        }
    }
} 