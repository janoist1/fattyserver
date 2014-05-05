<?php

namespace FattyServer\Handler\Exception;

use FattyServer\Handler\AbstractHandler;
use FattyServer\Packet\Output\NewTable;
use FattyServer\Packet\Output\PacketPropagator;
use FattyServer\Packet\Output\TableClosed;
use FattyServer\Player\PlayerManager;
use FattyServer\Table\Table;
use FattyServer\Table\TableManager;


class GameOverHandler extends AbstractHandler
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
     * Handles game over exception.
     * If the table is temporary, close it and let players know about it.
     */
    public function handle()
    {
        $this->tableManager->removeTable($this->table);

        if ($this->table->isTemporary()) {
            $this->propagator->sendPacket(new TableClosed($this->table));

            unset($this->table);

            if ($this->tableManager->getTables()->count() < 1) {
                $table = $this->tableManager->createAndAddTable(TableManager::DEFAULT_TABLE_NAME);

                $this->propagator->sendPacket(new NewTable($table));
            }
        }
    }
} 