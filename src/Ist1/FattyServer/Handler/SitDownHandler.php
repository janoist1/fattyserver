<?php

namespace FattyServer\Handler;

use FattyServer\FattyConnection;
use FattyServer\FattyServerProtocol;
use FattyServer\Packet\Input\SitDown as SitDownIn;
use FattyServer\Packet\Output\PlayersList\TablePlayersList;
use FattyServer\Packet\Output\SitDown as SitDownOut;
use FattyServer\Table\Table;
use FattyServer\Table\TableManager;


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
        $player = $serverProtocol->getPlayerManager()->getPlayer($fattyConnFrom);
        $table = $serverProtocol->getTableManager()->getTableById($this->packet->getTableId());

        $table->addPlayer($player);

        $fattyConnFrom->sendPacket(
            new TablePlayersList($table->getPlayers())
        );
        $serverProtocol->getPropagator()->sendPacketToPlayers(
            new SitDownOut($player, $table),
            $fattyConnFrom
        );
    }
} 