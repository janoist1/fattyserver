<?php

namespace FattyServer\Handler;

use FattyServer\FattyConnection;
use FattyServer\FattyServerProtocol;
use FattyServer\Packet\Output\PlayerLeft;


class PlayerLeftHandler implements HandlerInterface
{
    /**
     * Removes a player and let others know about it.
     *
     * @param FattyConnection $fattyConnFrom
     * @param FattyServerProtocol $serverProtocol
     */
    public function handle(FattyConnection $fattyConnFrom, FattyServerProtocol $serverProtocol)
    {
        $player = $serverProtocol->getPlayerManager()->getPlayers()->getOne($fattyConnFrom);
        $table = $serverProtocol->getTableManager()->getTableByPlayer($player);

        $player->setConnected(false);
        $serverProtocol->getPlayerManager()->getPlayers()->remove($player);

        $serverProtocol->getPropagator()->sendPacketToPlayers(new PlayerLeft($player));

        if ($table != null) {
            $table->playerLeft($player);

            if ($player == $table->getCurrentPlayer()) {
                // todo: make a turn instead of the Player
            }
        }
    }
} 