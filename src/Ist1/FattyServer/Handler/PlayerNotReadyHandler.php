<?php

namespace FattyServer\Handler;

use FattyServer\FattyConnection;
use FattyServer\FattyServerProtocol;
use FattyServer\Packet\Input\PlayerNotReady;
use FattyServer\Packet\Input;
use FattyServer\Packet\Output;


class PlayerNotReadyHandler implements HandlerInterface
{
    /**
     * @var Input\PlayerNotReady
     */
    protected $packet;

    /**
     * @param Input\PlayerNotReady $packet
     */
    function __construct(Input\PlayerNotReady $packet)
    {
        $this->packet = $packet;
    }

    /**
     * Handles ReadyNotPlayer request.
     * Propagates it to all other Players in the same Table.
     *
     * @param FattyConnection $fattyConnFrom
     * @param FattyServerProtocol $serverProtocol
     */
    public function handle(FattyConnection $fattyConnFrom, FattyServerProtocol $serverProtocol)
    {
        $player = $serverProtocol->getPlayerManager()->getPlayers()->getOne($fattyConnFrom);
        $table = $serverProtocol->getTableManager()->getTableByPlayer($player);

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

        $serverProtocol->getPropagator()->sendPacketToTable(
            new Output\PlayerNotReady($player),
            $table
        );
    }
} 