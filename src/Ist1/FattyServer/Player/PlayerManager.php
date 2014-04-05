<?php

namespace FattyServer\Player;

use FattyServer\FattyConnection;


class PlayerManager
{

    /**
     * @var \SplObjectStorage
     */
    protected $players;

    /**
     * Construct.
     */
    public function __construct()
    {
        $this->players = new \SplObjectStorage();
    }

    /**
     * Creates and returns a Player.
     *
     * @param FattyConnection $conn
     * @param $name
     * @return Player
     */
    public function createPlayer(FattyConnection $conn, $name)
    {
        return new Player($conn, $name);
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
     * Creates a Player, adds it to the manager,
     * and returns the new Player.
     *
     * @param FattyConnection $conn
     * @param $name
     * @return Player
     */
    public function createAndAddPlayer(FattyConnection $conn, $name)
    {
        $player = $this->createPlayer($conn, $name);
        $this->addPlayer($player);

        return $player;
    }

    /**
     * Returns a Player based on its FattyConnection
     *
     * @param FattyConnection $conn
     * @return Player
     */
    public function getPlayer(FattyConnection $conn)
    {
        /** @var Player $player */
        $player = $this->players[$conn];

        return $player;
    }

    /**
     * @return \SplObjectStorage
     */
    public function getPlayers()
    {
        return $this->players;
    }
} 