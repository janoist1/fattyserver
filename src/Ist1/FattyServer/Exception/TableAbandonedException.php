<?php

namespace FattyServer\Exception;

use FattyServer\Handler\Exception\TableAbandonedHandler;
use FattyServer\Table\Table;
use FattyServer\Table\TableManager;
use FattyServer\Player\PlayerManager;
use FattyServer\Packet\Output\PacketPropagator;


class TableAbandonedException extends AbstractGameException
{
    /**
     * @var Table
     */
    private $table;

    /**
     * @param Table $table
     */
    function __construct(Table $table)
    {
        $this->table = $table;
    }

    /**
     * {@inheritdoc}
     */
    public function getHandler(
        PlayerManager $playerManager,
        TableManager $tableManager,
        PacketPropagator $propagator)
    {
        return new TableAbandonedHandler(
            $playerManager,
            $tableManager,
            $propagator,
            $this->table
        );
    }
} 