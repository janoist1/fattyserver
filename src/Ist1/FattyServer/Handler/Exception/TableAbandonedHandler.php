<?php

namespace FattyServer\Handler\Exception;

use FattyServer\Handler\AbstractHandler;
use FattyServer\Packet\Output\PacketPropagator;
use FattyServer\Packet\Output\TableClosed;
use FattyServer\Player\PlayerManager;
use FattyServer\Table\Table;
use FattyServer\Table\TableManager;


class TableAbandonedHandler extends AbstractHandler
{
    /**
     * @var Table
     */
    private $table;

    /**
     * @param PlayerManager $playerManager
     * @param TableManager $tableManager
     * @param PacketPropagator $propagator
     * @param Table $table
     */
    function __construct(
        PlayerManager $playerManager,
        TableManager $tableManager,
        PacketPropagator $propagator,
        Table $table)
    {
        parent::__construct($playerManager, $tableManager, $propagator);

        $this->table = $table;
    }

    /**
     * Handles table abandoned exception.
     * If the table is temporary, close it and let the players know about it
     * else reset it.
     */
    public function handle()
    {
        if ($this->table->isTemporary()) {
            $this->propagator->sendPacket(new TableClosed($this->table));
            $this->tableManager->removeTable($this->table);
            unset($this->table);
        } else {
            $this->table->reset();
        }
    }
} 