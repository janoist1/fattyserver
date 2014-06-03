<?php

namespace FattyServer\Player;

use FattyServer\Card\CardStorage;
use FattyServer\FattyConnection;


class Player
{
    /**
     * @var FattyConnection
     */
    protected $connection;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var bool
     */
    protected $isConnected;

    /**
     * @var bool
     */
    protected $isReady;

    /**
     * @var bool
     */
    protected $isSwapDone;

    /**
     * @var CardStorage
     */
    protected $cardsHand;

    /**
     * @var CardStorage
     */
    protected $cardsUp;

    /**
     * @var CardStorage
     */
    protected $cardsDown;

    /**
     * @param FattyConnection $conn
     * @param $name
     */
    function __construct(FattyConnection $conn, $name)
    {
        $this->isConnected = true;
        $this->connection = $conn;
        $this->name = $name;
        $this->isReady = false;
        $this->isSwapDone = false;
        $this->cardsHand = new CardStorage();
        $this->cardsUp = new CardStorage();
        $this->cardsDown = new CardStorage();
    }

    /**
     * @param $cardsUpIds
     */
    public function swapCards(array $cardsUpIds)
    {
        $this->getCardsUp()->transferAllTo($this->getCardsHand());
        $this->getCardsHand()->transferByIdsTo($cardsUpIds, $this->getCardsUp());
    }

    /**
     * Returns true if Player has Cards only face-down
     *
     * @return bool
     */
    public function hasToPutRandomly()
    {
        return $this->cardsHand->count() < 1 && $this->cardsUp->count() < 1;
    }

    /**
     * @return FattyConnection
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->connection->getId();
    }

    /**
     * @param boolean $isConnected
     */
    public function setConnected($isConnected)
    {
        $this->isConnected = $isConnected;
    }

    /**
     * @return boolean
     */
    public function isConnected()
    {
        return $this->isConnected;
    }

    /**
     * @param boolean $isReady
     */
    public function setReady($isReady)
    {
        $this->isReady = $isReady;
    }

    /**
     * @return boolean
     */
    public function isReady()
    {
        return $this->isReady;
    }

    /**
     * @param boolean $isSwapDone
     */
    public function setSwapDone($isSwapDone)
    {
        $this->isSwapDone = $isSwapDone;
    }

    /**
     * @return boolean
     */
    public function isSwapDone()
    {
        return $this->isSwapDone;
    }

    /**
     * @return CardStorage
     */
    public function getCardsDown()
    {
        return $this->cardsDown;
    }

    /**
     * @return CardStorage
     */
    public function getCardsHand()
    {
        return $this->cardsHand;
    }

    /**
     * @return CardStorage
     */
    public function getCardsUp()
    {
        return $this->cardsUp;
    }
}