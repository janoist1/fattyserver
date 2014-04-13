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
    public function add(Card $card)
    {
        $this->cards[$card->getId()] = $card;
    }

    /**
     * @param array $cards
     */
    public function addArray(array $cards)
    {
        /** @var Card $card */
        foreach ($cards as $card) {
            $this->add($card);
        }
    }

    /**
     * @param Card $card
     */
    public function remove(Card $card)
    {
        unset($this->cards[$card->getId()]);
    }

    /**
     * @param int $id
     */
    public function removeById($id)
    {
        unset($this->cards[$id]);
    }

    /**
     * @param array $ids
     */
    public function removeByIds($ids)
    {
        foreach ($ids as $id) {
            $this->removeById($id);
        }
    }

    /**
     *
     */
    public function removeAll()
    {
        $this->cards = array();
    }

    /**
     * Picks out N Card randomly and returns them
     * Returns null if there are no more cards left
     *
     * @param int $num
     * @return array
     */
    public function randomPick($num = 1)
    {
        $randomCards = array();
        $cardsCount = $this->count();

        for ($i = 1; $i <= $num && $cardsCount--; $i++) {
            $id = array_rand($this->getAll());
            $randomCards[$id] = $this->getById($id);
            $this->removeById($id);
        }

        return $randomCards;
    }

    /**
     * @param CardStorage $transferTo
     */
    public function transferAllTo(CardStorage $transferTo)
    {
        foreach ($this->cards as $card) {
            $transferTo->add($card);
            $this->remove($card);
        }
    }

    /**
     * @param array $ids
     * @param CardStorage $transferTo
     */
    public function transferByIdsTo(array $ids, CardStorage $transferTo)
    {
        foreach ($ids as $id) {
            $card = $this->getById($id);
            $transferTo->add($card);
            $this->remove($card);
        }
    }

    /**
     * @return Card
     */
    public function getLastCard()
    {
        return end($this->cards);
    }

    /**
     * @return Card
     */
    public function getCardAt($index)
    {
        if ($index >= $this->count()) {
            return null;
        }

        $ids = array_keys($this->cards);

        return $this->cards[$ids[$index]];
    }

    /**
     * @return int
     */
    public function countLastValue()
    {
        if (count($this->cards) < 1) {
            return 0;
        }

        $count = 1;
        $value = end($this->cards)->getValue();

        /** @var Card $card */
        while ($card = prev($this->cards) && $card->getValue() == $value) {
            $count++;
        };

        return $count;
    }

    /**
     * @param string $id
     * @return bool
     */
    public function hasId($id)
    {
        return array_key_exists($id, $this->cards);
    }

    /**
     * @param string $id
     * @return Card
     */
    public function getById($id)
    {
        return $this->cards[$id];
    }

    /**
     * @return array
     */
    public function getAll()
    {
        return $this->cards;
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
    public function getIds()
    {
        return array_keys($this->cards);
    }
} 