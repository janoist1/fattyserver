<?php

namespace FattyServer\Table;

use FattyServer\Card\Card;
use FattyServer\Card\CardStorage;
use FattyServer\Card\Dealer;
use FattyServer\Exception\GameOverException;
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
     * @var bool
     */
    protected $isReady;

    /**
     * @var bool
     */
    protected $isSwapDone;

    /**
     * @var Dealer
     */
    protected $dealer;

    /**
     * @var PlayerStorage
     */
    protected $players;

    /**
     * @var PlayerStorage
     */
    protected $playersLeft;

    /**
     * @var PlayerStorage
     */
    protected $playersFinished;

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
        $this->isReady = false;
        $this->isSwapDone = false;
        $this->dealer = new Dealer();
        $this->players = new PlayerStorage();
        $this->playersLeft = new PlayerStorage();
        $this->playersFinished = new PlayerStorage();
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
        if ($this->isReady) {
            return true;
        }

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

        return $this->isReady = true;
    }

    /**
     * @return bool
     */
    public function isSwapDone()
    {
        if ($this->isSwapDone) {
            return true;
        }

        foreach ($this->players->getAll() as $conn) {
            /** @var Player $player */
            $player = $this->players->getOne($conn);
            if (!$player->isSwapDone()) {
                return false;
            }
        }

        return $this->isSwapDone = true;
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
     * @throws GameOverException
     */
    public function turn()
    {
        $playersCount = $this->players->getAll()->count();
        $playersLeftCount = $this->playersLeft->getAll()->count();

        // add who finished and left
        foreach ($this->playersFinished->getAll() as $conn) {
            if ($this->isPlayerLeft($this->playersFinished->getOne($conn))) {
                $playersCount++;
            }
        }

        if ($playersCount < 2 || $playersCount - $playersLeftCount == 1) {
            throw new GameOverException($this);
        }

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

    /**
     * @param Player $player
     */
    public function playerLeft(Player $player)
    {
        if ($this->isReady()) {
            $this->playersLeft->add($player);
        } else {
            $this->players->remove($player);
        }
    }

    /**
     * @param Player $player
     */
    public function playerFinished(Player $player)
    {
        $this->playersFinished->add($player);
        $this->players->remove($player);
    }

    /**
     * @param Player $player
     * @return bool
     */
    public function hasPlayer(Player $player)
    {
        return $this->players->contains($player);
    }

    /**
     * @param Player $player
     * @return bool
     */
    public function isPlayerLeft(Player $player)
    {
        return $this->playersLeft->contains($player);
    }

    /**
     * @param Player $player
     * @return bool
     */
    public function isPlayerFinished(Player $player)
    {
        return $this->playersFinished->contains($player);
    }

    /**
     * @param Player $player
     * @return bool
     */
    public function isPlayerActive(Player $player)
    {
        return $this->hasPlayer($player) && !$this->isPlayerLeft($player) && !$this->isPlayerFinished($player);
    }

    /**
     * @return bool
     */
    public function isFull()
    {
        return $this->players->getAll()->count() >= Dealer::RULE_MAX_PLAYERS;
    }
} 