<?php

namespace FattyServer\Card;


class CardStorage
{
    /**
     * @var array
     */
    protected $cards = array();

    /**
     * @param array $cards
     */
    function __construct(array $cards = null)
    {
        $this->cards = $cards;
    }

    /**
     * @param Card $card
     */
    public function addCard(Card $card)
    {
        $this->cards[$card->getId()] = $card;
    }

    /**
     * @param array $cards
     */
    public function addCards(array $cards)
    {
        /** @var Card $card */
        foreach ($cards as $card) {
            $this->addCard($card);
        }
    }

    /**
     * @param Card $card
     */
    public function removeCard(Card $card)
    {
        unset($this->cards[$card->getId()]);
    }

    /**
     * @param int $id
     */
    public function removeCardById($id)
    {
        unset($this->cards[$id]);
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->cards);
    }

    /**
     * @return array
     */
    public function getCards()
    {
        return $this->cards;
    }

    /**
     * @return array
     */
    public function getIds()
    {
        return array_keys($this->cards);

    }
} 