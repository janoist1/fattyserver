<?php

namespace FattyServer\Card;

use FattyServer\Player\Player;
use FattyServer\Table\Table;


class Dealer
{
    const RULE_CARDS_HAND = 3;
    const RULE_CARDS_UP = 3;
    const RULE_CARDS_DOWN = 3;
    const RULE_2_VALUE = 2;
    const RULE_8_VALUE = 8;
    const RULE_9_VALUE = 9;
    const RULE_10_VALUE = 10;
    const RULE_ACE_VALUE = 1;
    const RULE_BURN_COUNT = 4;

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
            $player->getCardsDown()->addArray($this->cards->randomPick(self::RULE_CARDS_DOWN));
            $player->getCardsUp()->addArray($this->cards->randomPick(self::RULE_CARDS_UP));
            $player->getCardsHand()->addArray($this->cards->randomPick(self::RULE_CARDS_UP));
        }
    }

    /**
     * @param $value
     * @param $lastValue
     * @return bool
     */
    public static function checkPass($value, $lastValue)
    {
        switch ($value) {
            case Dealer::RULE_2_VALUE:
            case Dealer::RULE_8_VALUE:
            case Dealer::RULE_10_VALUE:
            case Dealer::RULE_ACE_VALUE:
                return $lastValue != Dealer::RULE_9_VALUE;
                break;

            default:
                return $value >= $lastValue;
        }
    }

    /**
     * @param CardStorage $cardStorage
     * @param $lastValue
     * @return bool
     */
    public static function checkCardsPass(CardStorage $cardStorage, $lastValue)
    {
        /** @var Card $card */
        foreach ($cardStorage->getAll() as $card) {
            if (self::checkPass($card->getValue(), $lastValue)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param $value
     * @param CardStorage $cards
     * @return bool
     */
    public static function checkBurn($value, CardStorage $cards)
    {
        return $value == self::RULE_10_VALUE || $cards->countLastValue() == self::RULE_BURN_COUNT;
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