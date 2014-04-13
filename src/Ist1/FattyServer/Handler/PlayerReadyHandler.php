<?php

namespace FattyServer\Handler;

use FattyServer\FattyConnection;
use FattyServer\FattyServerProtocol;
use FattyServer\Packet\Input\PlayerReady as PlayerReadyIn;
use FattyServer\Packet\Output\GameStart;
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
     * @param FattyServerProtocol $serverProtocol
     */
    public function handle(FattyConnection $fattyConnFrom, FattyServerProtocol $serverProtocol)
    {
        $player = $serverProtocol->getPlayerManager()->getPlayers()->getOne($fattyConnFrom);
        $table = $serverProtocol->getTableManager()->getTableByPlayer($player);

        if ($player->isReady()) {
            // todo: handle Player is already ready
            return;
        }

        $player->setReady(true);

        $serverProtocol->getPropagator()->sendPacketToPlayers(
            new PlayerReadyOut($player)
        );

        if ($table->isReady()) {
            $table->getDealer()->deal($table->getPlayers()->getAll());

            $players = $serverProtocol->getPlayerManager()->getPlayers()->getAll();

            /** @var FattyConnection $conn */
            foreach ($players as $conn) {
                $conn->sendPacket(new GameStart($players->offsetGet($conn), $table));
            }
        }
    }
} 