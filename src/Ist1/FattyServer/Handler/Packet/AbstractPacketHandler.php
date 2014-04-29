<?php

namespace FattyServer\Handler\Packet;

use FattyServer\FattyConnection;
use FattyServer\Handler\AbstractHandler;
use FattyServer\Packet\Output\Gathering;
use FattyServer\Packet\Output\NewTable;
use FattyServer\Packet\Output\PacketPropagator;
use FattyServer\Packet\Output\SitDown;
use FattyServer\Player\Player;
use FattyServer\Player\PlayerManager;
use FattyServer\Table\Table;
use FattyServer\Table\TableManager;


abstract class AbstractPacketHandler extends AbstractHandler
{
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
        parent::__construct(
            $playerManager,
            $tableManager,
            $propagator
        );

        $this->connection = $connection;
    }

    /**
     * @param Player $player
     * @param Table $table
     */
    public function sitDown(Player $player, Table $table)
    {
        $table->getPlayers()->add($player);

        $this->connection->sendPacket(new Gathering($table));

        $this->propagator->sendPacketToAll(
            new SitDown($player, $table)
        );
    }
} 