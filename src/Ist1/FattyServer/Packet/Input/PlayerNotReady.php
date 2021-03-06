<?php

namespace FattyServer\Packet\Input;

use FattyServer\FattyConnection;
use FattyServer\Handler\Connection\ConnectionHandlerInterface;
use FattyServer\Handler\Connection\Packet\PlayerNotReadyHandler;
use FattyServer\Packet\Output\PacketPropagator;
use FattyServer\Player\PlayerManager;
use FattyServer\Table\TableManager;


class PlayerNotReady implements ConnectionHandlerInterface {

    /**
     * @param array $data
     * @throws \Exception
     */
    function __construct(array $data = null)
    {
        if ($data !== null) {
            throw new \Exception('Invalid PlayerNotReady packet');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getHandler(
        PlayerManager $playerManager,
        TableManager $tableManager,
        PacketPropagator $propagator,
        FattyConnection $connection)
    {
        return new PlayerNotReadyHandler(
            $playerManager,
            $tableManager,
            $propagator,
            $connection
        );
    }
} 