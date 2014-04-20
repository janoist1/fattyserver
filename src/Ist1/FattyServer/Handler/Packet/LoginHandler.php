<?php

namespace FattyServer\Handler\Packet;

use FattyServer\FattyConnection;
use FattyServer\Handler\AbstractHandler;
use FattyServer\Packet\Input;
use FattyServer\Packet\Output;
use FattyServer\Packet\Output\NewPlayer;
use FattyServer\Packet\Output\PacketPropagator;
use FattyServer\Packet\Output\PlayersList\PlayersList;
use FattyServer\Packet\Output\TablesList;
use FattyServer\Player\PlayerManager;
use FattyServer\Table\TableManager;


class LoginHandler extends AbstractHandler
{
    /**
     * @var Input\Login
     */
    protected $packet;

    /**
     * @param PlayerManager $playerManager
     * @param TableManager $tableManager
     * @param PacketPropagator $propagator
     * @param FattyConnection $connection
     * @param Input\Login $packet
     */
    function __construct(
        PlayerManager $playerManager,
        TableManager $tableManager,
        PacketPropagator $propagator,
        FattyConnection $connection,
        Input\Login $packet)
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
     * Handles login request.
     */
    public function handle()
    {
        $player = $this->playerManager->getPlayers()->getById($this->connection->getId());

        if ($player !== null) {
            // todo: handle Player already logged in
            return;
        }

        $player = $this->playerManager->createAndAddPlayer(
            $this->connection, $this->packet->getName()
        );
        $tables = $this->tableManager->getTables();

        $this->connection->sendPacket(new Output\Login());
        $this->connection->sendPacket(new TablesList($tables));
        $this->connection->sendPacket(
            new PlayersList($this->playerManager->getPlayers()->getAll())
        );
        $this->propagator->sendPacketToPlayers(
            new NewPlayer($player),
            $this->connection
        );

        // httpRequest to the aPI....
    }
} 