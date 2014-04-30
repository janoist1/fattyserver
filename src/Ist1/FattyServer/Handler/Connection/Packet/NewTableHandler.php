<?php

namespace FattyServer\Handler\Connection\Packet;

use FattyServer\FattyConnection;
use FattyServer\Handler\AbstractHandler;
use FattyServer\Handler\Connection\AbstractConnectionHandler;
use FattyServer\Packet\Input;
use FattyServer\Packet\Output;
use FattyServer\Packet\Output\PacketPropagator;
use FattyServer\Packet\Output\Gathering;
use FattyServer\Packet\Output\TablesList;
use FattyServer\Packet\Output\PlayersList\PlayersList;
use FattyServer\Player\PlayerManager;
use FattyServer\Table\TableManager;


class NewTableHandler extends AbstractConnectionHandler
{
    /**
     * @var Input\NewTable
     */
    protected $packet;

    /**
     * @param PlayerManager $playerManager
     * @param TableManager $tableManager
     * @param PacketPropagator $propagator
     * @param FattyConnection $connection
     * @param Input\NewTable $packet
     */
    function __construct(
        PlayerManager $playerManager,
        TableManager $tableManager,
        PacketPropagator $propagator,
        FattyConnection $connection,
        Input\NewTable $packet)
    {
        parent::__construct(
            $playerManager,
            $tableManager,
            $propagator,
            $connection
        );

        $this->packet = $packet;
    }

    /**
     * Handles new table request.
     */
    public function handle()
    {
        $table = $this->tableManager->getTableByName($this->packet->getName());

        if ($table !== null) {
            // todo: handle Table name already exists
            return;
        }

        $player = $this->playerManager->getPlayers()->getOne($this->connection);
        $table = $this->newTable($this->packet->getName());

        $this->sitDown($player, $table);
    }
} 