<?php

namespace FattyServer\Handler;

use FattyServer\FattyConnection;
use FattyServer\FattyServerProtocol;
use FattyServer\Packet\Input\SitDown as SitDownIn;
use FattyServer\Packet\Output\Gathering;
use FattyServer\Packet\Output\SitDown as SitDownOut;


class SitDownHandler implements HandlerInterface
{
    /**
     * @var SitDownIn
     */
    protected $packet;

    /**
     * @param SitDownIn $packet
     */
    function __construct(SitDownIn $packet)
    {
        $this->packet = $packet;
    }

    /**
     * Handles a sit down at a table request.
     *
     * @param FattyConnection $fattyConnFrom
     * @param FattyServerProtocol $serverProtocol
     */
    public function handle(FattyConnection $fattyConnFrom, FattyServerProtocol $serverProtocol)
    {
        $player = $serverProtocol->getPlayerManager()->getPlayers()->getOne($fattyConnFrom);
        $table = $serverProtocol->getTableManager()->getTableByPlayer($player);

        if ($table !== null) {
            // todo: handle Player already sat to another Table
            return;
        }

        $table = $serverProtocol->getTableManager()->getTableById($this->packet->getTableId());

        if ($table === null) {
            // todo: handle Table not exists
            return;
        }
        if ($table->isFull()) {
            // todo: handle max Player limit reached, no more can sit
            return;
        }
        if ($table->hasPlayer($player)) {
            // todo: handle Player already sat to this Table
            return;
        }
        if ($table->isReady()) {
            // todo: handle Table is ready, no more Player can sit
            return;
        }

        $table->getPlayers()->add($player);

        $fattyConnFrom->sendPacket(new Gathering($table));

        $serverProtocol->getPropagator()->sendPacketToPlayers(
            new SitDownOut($player, $table)
        );
    }
} 