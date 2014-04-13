<?php

namespace FattyServer\Player;

use FattyServer\FattyConnection;


class PlayerManager
{
    /**
     * @var PlayerStorage
     */
    protected $players;

    /**
     * Construct.
     */
    public function __construct()
    {
        $this->players = new PlayerStorage();
    }

    /**
     * Creates and returns a Player.
     *
     * @param FattyConnection $conn
     * @param $name
     * @return Player
     */
    public static function createPlayer(FattyConnection $conn, $name)
    {
        return new Player($conn, $name);
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
        $player = self::createPlayer($conn, $name);
        $this->players->add($player);

        return $player;
    }

    /**
     * @return PlayerStorage
     */
    public function getPlayers()
    {
        return $this->players;
    }
} 