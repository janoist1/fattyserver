<?php

namespace FattyServer\Packet\Input;

use FattyServer\FattyConnection;
use FattyServer\Handler\AbstractHandler;
use FattyServer\Packet\Output\PacketPropagator;
use FattyServer\Player\PlayerManager;
use FattyServer\Table\TableManager;


interface InputPacketInterface
{
    /**
     * @param array $data
     */
    function __construct(array $data = null);

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