<?php

namespace FattyServer\Handler\Connection\Packet;

use FattyServer\FattyConnection;
use FattyServer\Handler\AbstractHandler;
use FattyServer\Handler\Connection\AbstractConnectionHandler;
use FattyServer\Packet\Input;
use FattyServer\Packet\Output;
use FattyServer\Packet\Output\PacketPropagator;
use FattyServer\Packet\Output\SwapDone;
use FattyServer\Player\PlayerManager;
use FattyServer\Table\TableManager;


class SwapHandler extends AbstractConnectionHandler
{
    /**
     * @var Input\Swap
     */
    protected $packet;

    /**
     * @param PlayerManager $playerManager
     * @param TableManager $tableManager
     * @param PacketPropagator $propagator
     * @param FattyConnection $connection
     * @param Input\Swap $packet
     */
    function __construct(
        PlayerManager $playerManager,
        TableManager $tableManager,
        PacketPropagator $propagator,
        FattyConnection $connection,
        Input\Swap $packet)
    {
        parent::__construct(
            $playerManager,
            $tableManager,
            $propagator,
            $connection
        );

        $this->packet = $packet;
    }

    /**
     * Handles Swap card request.
     */
    public function handle()
    {
        $player = $this->playerManager->getPlayers()->getOne($this->connection);
        $table = $this->tableManager->getTableByPlayer($player);

        if (!$table->isPlayerActive($player)) {
            // todo: handle Player is not playing at this Table
            return;
        }
        if ($player->isSwapDone()) {
            // todo: handle swap already done
            return;
        }

        // todo: check if the Player has sent valid Cards
        $player->swapCards($this->packet->getCardsUp());
        $player->setSwapDone(true);

        $this->propagator->sendPacketToTable(
            new Output\Swap($player),
            $table,
            $this->connection
        );

        if ($table->isSwapDone()) {
            // todo: handle if the starting Player has left
            $player = $table->getStartingPlayer();

            $this->propagator->sendPacketToTable(
                new SwapDone($player),
                $table
            );

            $table->setActivePlayer($player);
        }
    }
} 