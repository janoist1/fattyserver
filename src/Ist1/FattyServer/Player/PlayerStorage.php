<?php

namespace FattyServer\Player;

use FattyServer\FattyConnection;


class PlayerStorage
{
    /**
     * @var \SplObjectStorage
     */
    protected $players;

    /**
     * @param $name
     */
    function __construct()
    {
        $this->players = new \SplObjectStorage();
    }

    /**
     * Adds a Player to the manager.
     *
     * @param Player $player
     */
    public function addPlayer(Player $player)
    {
        $this->players->attach($player->getConnection(), $player);
    }

    /**
     * Adds a Player to the manager.
     *
     * @param Player $player
     */
    public function removePlayer(Player $player)
    {
        $this->players->offsetUnset($player->getConnection());
    }

    /**
     * Returns a Player based on its FattyConnection
     *
     * @param FattyConnection $conn
     * @return Player
     */
    public function getPlayer(FattyConnection $conn)
    {
        return $this->players->offsetGet($conn);
    }

    /**
     * @return \SplObjectStorage
     */
    public function getPlayers()
    {
        return $this->players;
    }
} 