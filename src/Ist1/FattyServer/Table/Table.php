<?php

namespace FattyServer\Table;

use FattyServer\Card\Card;
use FattyServer\Card\CardStorage;
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
     * @var CardStorage
     */
    protected $cards;

    /**
     * @var Player
     */
    protected $currentPlayer;

    /**
     * @param $name
     */
    function __construct($name)
    {
        parent::__construct();

        $this->id = uniqid();
        $this->name = $name;
        $this->dealer = new Dealer();
        $this->cards = new CardStorage();
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
     * @param Player $currentPlayer
     */
    public function setCurrentPlayer($currentPlayer)
    {
        $this->currentPlayer = $currentPlayer;
    }

    /**
     * @return Player
     */
    public function getCurrentPlayer()
    {
        return $this->currentPlayer;
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

    /**
     * @return $this
     */
    public function turn()
    {
        foreach ($this->players as $conn) {
            /** @var Player $player */
            $player = $this->players[$conn];
            if ($player == $this->currentPlayer) {
                $this->players->next();
                if (!$this->players->valid()) {
                    $this->players->rewind();
                }
                $this->currentPlayer = $this->players
                    ->offsetGet($this->players->current());
            }
        }

        return $this;
    }

    /**
     * @return CardStorage
     */
    public function getCards()
    {
        return $this->cards;
    }
} 