<?php

namespace FattyServer\Table;

use FattyServer\Card\Dealer;
use FattyServer\Player\Player;
use FattyServer\Player\PlayerStorage;


class Table extends PlayerStorage
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var Dealer
     */
    protected $dealer;

    /**
     * @param $name
     */
    function __construct($name)
    {
        parent::__construct();

        $this->id = uniqid();
        $this->name = $name;
        $this->dealer = new Dealer();
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return Dealer
     */
    public function getDealer()
    {
        return $this->dealer;
    }

    /**
     * @return bool
     */
    public function isReady()
    {
        if ($this->players->count() <= 1) {
            return false;
        }

        foreach ($this->players as $conn) {
            /** @var Player $player */
            $player = $this->players[$conn];
            if (!$player->isReady()) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isSwapDone()
    {
        foreach ($this->players as $conn) {
            /** @var Player $player */
            $player = $this->players[$conn];
            if (!$player->isSwapDone()) {
                return false;
            }
        }

        return true;
    }

    /**
     * Returns the starting Player.
     * According to the rules this function
     * meant to return the Player that has
     * the lowest value card, but for now
     * temporary returns the first one.
     *
     * @return Player
     */
    public function getStartingPlayer()
    {
        $this->players->rewind();

        $conn = $this->players->current();
        return $this->players->offsetGet($conn);
    }
} 