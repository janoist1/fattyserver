<?php

namespace FattyServer\Handler;

use FattyServer\FattyConnection;
use FattyServer\Packet\Output\PacketPropagator;
use FattyServer\Player\PlayerManager;
use FattyServer\Table\TableManager;


abstract class AbstractHandler
{
    /**
     * @var PlayerManager
     */
    protected $playerManager;

    /**
     * @var TableManager
     */
    protected $tableManager;

    /**
     * @var PacketPropagator
     */
    protected $propagator;

    /**
     * @var FattyConnection
     */
    protected $connection;

    /**
     * @param PlayerManager $playerManager
     * @param TableManager $tableManager
     * @param PacketPropagator $propagator
     * @param FattyConnection $connection
     */
    function __construct(
        PlayerManager $playerManager,
        TableManager $tableManager,
        PacketPropagator $propagator,
        FattyConnection $connection)
    {
        $this->playerManager = $playerManager;
        $this->tableManager = $tableManager;
        $this->propagator = $propagator;
        $this->connection = $connection;
    }

    abstract public function handle();
} 