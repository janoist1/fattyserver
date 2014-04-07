<?php

namespace FattyServer\Handler;

use FattyServer\Card\CardStorage;
use FattyServer\FattyConnection;
use FattyServer\FattyServerProtocol;
use FattyServer\Packet\Input;
use FattyServer\Packet\Output;
use FattyServer\Packet\Output\SwapDone;


class SwapHandler implements HandlerInterface
{
    /**
     * @var Input\Swap
     */
    protected $packet;

    /**
     * @param Input\Swap $packet
     */
    function __construct(Input\Swap $packet)
    {
        $this->packet = $packet;
    }

    /**
     * Handles Swap card request.
     *
     * @param FattyConnection $fattyConnFrom
     * @param FattyServerProtocol $serverProtocol
     */
    public function handle(FattyConnection $fattyConnFrom, FattyServerProtocol $serverProtocol)
    {
        $player = $serverProtocol->getPlayerManager()->getPlayer($fattyConnFrom);
        $table = $serverProtocol->getTableManager()->getTableByConnection($fattyConnFrom);

        $player->swapCards($this->packet->getCardsUp());
        $player->setSwapDone(true);

        $serverProtocol->getPropagator()->sendPacketToTable(
            new Output\Swap($player),
            $table,
            $fattyConnFrom
        );

        if ($table->isSwapDone()) {
            $player = $table->getStartingPlayer();
            $serverProtocol->getPropagator()->sendPacketToTable(
                new SwapDone($player),
                $table
            );
        }
    }
} 