<?php

namespace FattyServer\Handler;

use FattyServer\Exception\TableAbandonedException;
use FattyServer\FattyConnection;
use FattyServer\Packet\Output\NewTable;
use FattyServer\Packet\Output\PacketPropagator;
use FattyServer\Player\Player;
use FattyServer\Player\PlayerManager;
use FattyServer\Table\Table;
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
     * @param PlayerManager $playerManager
     * @param TableManager $tableManager
     * @param PacketPropagator $propagator
     */
    function __construct(
        PlayerManager $playerManager,
        TableManager $tableManager,
        PacketPropagator $propagator)
    {
        $this->playerManager = $playerManager;
        $this->tableManager = $tableManager;
        $this->propagator = $propagator;
    }

    abstract public function handle();

    /**
     * @param $name
     * @param bool $isTemporary
     * @return Table
     */
    protected function newTable($name, $isTemporary = true)
    {
        $table = $this->tableManager->createAndAddTable($name, $isTemporary);

        $this->propagator->sendPacket(new NewTable($table));

        return $table;
    }

    /**
     * @param Player $player
     * @param Table $table
     */
    protected function playerLeft(Player $player, Table $table)
    {
        try {
            $table->playerLeft($player);
        } catch(TableAbandonedException $e) {
            $e->getHandler(
                $this->playerManager,
                $this->tableManager,
                $this->propagator
            )->handle();
        }
    }
} 