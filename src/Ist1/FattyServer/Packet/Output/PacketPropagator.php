<?php

namespace FattyServer\Packet\Output;


use FattyServer\FattyConnection;
use FattyServer\Player\Player;
use FattyServer\Player\PlayerManager;
use FattyServer\Table\Table;
use FattyServer\Table\TableManager;

class PacketPropagator
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
     * @param PlayerManager $playerManager
     * @param TableManager $tableManager
     */
    public function __construct(PlayerManager $playerManager, TableManager $tableManager)
    {
        $this->playerManager = $playerManager;
        $this->tableManager = $tableManager;
    }

    /**
     * Propagates a Packet to all the Players
     *
     * @param AbstractOutputPacket $packet
     */
    public function sendPacket(
        AbstractOutputPacket $packet,
        FattyConnection $exclude = null)
    {
        $players = $this->playerManager->getPlayers()->getAll();

        /** @var FattyConnection $conn */
        foreach ($players as $conn) {
            /** @var Player $player */
            $player = $players->offsetGet($conn);
            if ($player->isConnected() && $conn !== $exclude) {
                $conn->sendPacket($packet);
            }
        }
    }

    /**
     * Propagates a Packet to Players in a Table
     *
     * @param AbstractOutputPacket $packet
     * @param Table $table
     */
    public function sendPacketToTable(
        AbstractOutputPacket $packet,
        Table $table,
        FattyConnection $exclude = null)
    {
        $players = $table->getPlayers()->getAll();

        /** @var FattyConnection $conn */
        foreach ($players as $conn) {
            /** @var Player $player */
            $player = $players->offsetGet($conn);
            if ($player->isConnected() && $conn !== $exclude) {
                $conn->sendPacket($packet);
            }
        }
    }
} 