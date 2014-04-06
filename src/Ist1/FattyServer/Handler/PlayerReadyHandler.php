<?php

namespace FattyServer\Handler;

use FattyServer\FattyConnection;
use FattyServer\FattyServerProtocol;
use FattyServer\Packet\Input\PlayerReady as PlayerReadyIn;
use FattyServer\Packet\Output\PlayerReady as PlayerReadyOut;


class PlayerReadyHandler implements HandlerInterface
{
    /**
     * @var PlayerReadyIn
     */
    protected $packet;

    /**
     * @param PlayerReadyIn $packet
     */
    function __construct(PlayerReadyIn $packet)
    {
        $this->packet = $packet;
    }

    /**
     * Handles ReadyPlayer request.
     * Propagates it to all other Players in the same Table.
     *
     * @param FattyConnection $fattyConnFrom
     */
    public function handle(FattyConnection $fattyConnFrom, FattyServerProtocol $serverProtocol)
    {
        $player = $serverProtocol->getPlayerManager()->getPlayer($fattyConnFrom);
        $player->setReady(true);

        $table = $serverProtocol->getTableManager()->getTableByConnection($fattyConnFrom);

        $serverProtocol->getPropagator()->sendPacketToTable(
            new PlayerReadyOut($player),
            $table
        );

        if ($table->isReady()) {
            // game shall start !
        }
    }
} 