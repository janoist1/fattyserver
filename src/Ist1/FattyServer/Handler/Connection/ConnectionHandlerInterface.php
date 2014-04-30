<?php

namespace FattyServer\Handler\Connection;

use FattyServer\FattyConnection;
use FattyServer\Packet\Output\PacketPropagator;
use FattyServer\Player\PlayerManager;
use FattyServer\Table\TableManager;
use FattyServer\Handler\AbstractHandler;


interface ConnectionHandlerInterface
{
    /**
     * @param PlayerManager $playerManager
     * @param TableManager $tableManager
     * @param PacketPropagator $propagator
     * @param FattyConnection $connection
     * @return AbstractHandler
     */
    public function getHandler(
        PlayerManager $playerManager,
        TableManager $tableManager,
        PacketPropagator $propagator,
        FattyConnection $connection);
}