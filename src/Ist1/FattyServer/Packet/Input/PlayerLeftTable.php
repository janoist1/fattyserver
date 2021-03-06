<?php

namespace FattyServer\Packet\Input;

use FattyServer\FattyConnection;
use FattyServer\Handler\Connection\ConnectionHandlerInterface;
use FattyServer\Handler\Connection\Packet\PlayerLeftTableHandler;
use FattyServer\Packet\Output\PacketPropagator;
use FattyServer\Player\PlayerManager;
use FattyServer\Table\TableManager;


class PlayerLeftTable implements ConnectionHandlerInterface {

    /**
     * @param array $data
     * @throws \Exception
     */
    function __construct(array $data = null)
    {
        if ($data !== null) {
            throw new \Exception('Invalid PlayerLeftTable packet');
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
        return new PlayerLeftTableHandler(
            $playerManager,
            $tableManager,
            $propagator,
            $connection
        );
    }
} 