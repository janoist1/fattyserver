<?php

namespace FattyServer\Packet\Input;

use FattyServer\FattyConnection;
use FattyServer\Handler\Packet\PlayerReadyHandler;
use FattyServer\Packet\Output\PacketPropagator;
use FattyServer\Player\PlayerManager;
use FattyServer\Table\TableManager;


class PlayerReady implements InputPacketInterface
{
    /**
     * @param array $data
     * @throws \Exception
     */
    function __construct(array $data = null)
    {
        if ($data !== null) {
            throw new \Exception('Invalid PlayerReady packet');
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
        return new PlayerReadyHandler(
            $playerManager,
            $tableManager,
            $propagator,
            $connection
        );
    }
} 