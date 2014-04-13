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
    public function add(Player $player)
    {
        $this->players->attach($player->getConnection(), $player);
    }

    /**
     * Adds a Player to the manager.
     *
     * @param Player $player
     */
    public function remove(Player $player)
    {
        $this->players->offsetUnset($player->getConnection());
    }

    /**
     * Removes a Player by its FattyConnection
     *
     * @param FattyConnection $conn
     */
    public function removeByConnection(FattyConnection $conn)
    {
        $this->players->offsetUnset($conn);
    }

    /**
     * Returns a Player based on its FattyConnection
     *
     * @param FattyConnection $conn
     * @return Player
     */
    public function getOne(FattyConnection $conn)
    {
        try {
            return $this->players->offsetGet($conn);
        } catch(\UnexpectedValueException $e) {
            return null;
        }
    }

    /**
     * Returns a Player based on its ID
     *
     * @param string $id
     * @return Player
     */
    public function getById($id)
    {
        foreach ($this->players as $conn) {
            /** @var Player $player */
            $player = $this->getOne($conn);
            if ($player->getId() == $id) {
                return $player;
            }
        }

        return null;
    }

    /**
     * @return \SplObjectStorage
     */
    public function getAll()
    {
        return $this->players;
    }

    /**
     * @return Player
     */
    public function getFirst()
    {
        $this->players->rewind();

        return $this->getOne($this->players->current());
    }

    /**
     * @param Player $currentPlayer
     * @return Player
     */
    public function getNext(Player $currentPlayer)
    {
        foreach ($this->players as $conn) {
            if ($conn == $currentPlayer->getConnection()) {
                $this->players->next();
                if (!$this->players->valid()) {
                    $this->players->rewind();
                }
                return $this->getOne($this->players->current());
            }
        }

        return null;
    }

    /**
     * @return array
     */
    public function getIds()
    {
        $ids = array();

        foreach ($this->players as $conn) {
            $ids[] = $this->getOne($conn)->getId();
        }

        return $ids;
    }

    /**
     * @param Player $player
     * @return bool
     */
    public function contains(Player $player)
    {
        return $this->players->contains($player->getConnection());
    }
} 