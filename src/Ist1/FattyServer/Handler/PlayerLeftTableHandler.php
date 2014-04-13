<?php

namespace FattyServer\Handler;

use FattyServer\FattyConnection;
use FattyServer\FattyServerProtocol;
use FattyServer\Packet\Output\PlayerLeft;
use FattyServer\Packet\Output\PlayerLeftTable;


class PlayerLeftTableHandler implements HandlerInterface
{
    /**
     * Removes a player from a table and let others know about it.
     *
     * @param FattyConnection $fattyConnFrom
     * @param FattyServerProtocol $serverProtocol
     */
    public function handle(FattyConnection $fattyConnFrom, FattyServerProtocol $serverProtocol)
    {
        $player = $serverProtocol->getPlayerManager()->getPlayers()->getOne($fattyConnFrom);
        $table = $serverProtocol->getTableManager()->getTableByPlayer($player);

        if ($table->isPlayerLeft($player)) {
            // todo: handle player not exists
            return;
        }

        $table->playerLeft($player);
        $player->setReady(false);
        $player->setSwapDone(false);

        $serverProtocol->getPropagator()->sendPacketToPlayers(new PlayerLeftTable($player));

        if ($player == $table->getCurrentPlayer()) {
            // todo: make a turn instead of the Player
        }
    }
} 