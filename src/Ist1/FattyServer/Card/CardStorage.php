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
     * Picks out N Card randomly and returns them
     * Returns null if there are no more cards left
     *
     * @param int $num
     * @return array|Card
     */
    public function randomPick($num = 1)
    {
        $randomCards = array();
        $cardsCount = $this->count();

        for ($i = 1; $i <= $num && $cardsCount--; $i++) {
            $id = array_rand($this->getAll());
            $randomCards[] = $this->getById($id);
            $this->removeById($id);
        }

        return count($randomCards) > 1 ? $randomCards : array_shift($randomCards);
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