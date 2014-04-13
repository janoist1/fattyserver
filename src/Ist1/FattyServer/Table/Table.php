<?php

namespace FattyServer\Table;

use FattyServer\Card\Card;
use FattyServer\Card\CardStorage;
use FattyServer\Card\Dealer;
use FattyServer\Player\Player;
use FattyServer\Player\PlayerStorage;


class Table
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
     * @var PlayerStorage
     */
    protected $players;

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
        $this->id = uniqid();
        $this->name = $name;
        $this->dealer = new Dealer();
        $this->players = new PlayerStorage();
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
        if ($this->players->getAll()->count() <= 1) {
            return false;
        }

        foreach ($this->players->getAll() as $conn) {
            /** @var Player $player */
            $player = $this->players->getOne($conn);
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
        foreach ($this->players->getAll() as $conn) {
            /** @var Player $player */
            $player = $this->players->getOne($conn);
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
        return $this->players->getFirst();
    }

    /**
     * @return $this
     */
    public function turn()
    {
        $this->currentPlayer = $this->players->getNext($this->currentPlayer);

        return $this;
    }

    /**
     * @return CardStorage
     */
    public function getCards()
    {
        return $this->cards;
    }

    /**
     * @return PlayerStorage
     */
    public function getPlayers()
    {
        return $this->players;
    }
} 