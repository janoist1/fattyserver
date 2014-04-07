<?php

namespace FattyServer\Card;

use FattyServer\Player\Player;
use FattyServer\Table\Table;


class Dealer
{
    const RULE_CARDS_HAND = 3;
    const RULE_CARDS_UP = 3;
    const RULE_CARDS_DOWN = 3;

    /**
     * @var CardStorage
     */
    protected $cards;

    /**
     * Construct
     */
    function __construct()
    {
        $this->cards = new CardStorage(self::generateCards());
    }

    /**
     * Deals Cards for each Player at the given Table
     *
     * @param Table $table
     */
    public function deal(\Iterator $players)
    {
        foreach ($players as $conn) {
            /** @var Player $player */
            $player = $players[$conn];
            $player->getCardsDown()->addCards($this->randomPick(self::RULE_CARDS_DOWN));
            $player->getCardsUp()->addCards($this->randomPick(self::RULE_CARDS_UP));
            $player->getCardsHand()->addCards($this->randomPick(self::RULE_CARDS_UP));
        }
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

        for ($i = 1; $i <= $num && $this->cards->count(); $i++) {
            $id = array_rand($this->cards->getCards());
            $randomCards[] = $this->cards->getCardById($id);
            $this->cards->removeCardById($id);
        }

        return count($randomCards) > 1 ? $randomCards : array_shift($randomCards);
    }

    /**
     * Returns an ordered array of cards
     *
     * @return array
     */
    public static function generateCards()
    {
        $cards = array();
        $types = array(
            Card::TYPE_CLUBS,
            Card::TYPE_DIAMONDS,
            Card::TYPE_HEARTS,
            Card::TYPE_SPADES,
        );
        foreach ($types as $type) {
            for ($value = 1; $value <= 13; $value++) {
                $card = new Card($type, $value);
                $cards[$card->getId()] = $card;
            }
        }

        return $cards;
    }

    /**
     * Generates N dummy Cards
     *
     * @param int $num
     * @return array|Card
     */
    public static function generateDummy($num = 1)
    {
        $cards = array();

        for ($i = 1; $i <= $num; $i++) {
            $card = new Card(Card::TYPE_DUMMY, $i);
            $cards[$card->getId()] = $card;
        }

        return count($cards) > 1 ? $cards : array_shift($cards);
    }
} 