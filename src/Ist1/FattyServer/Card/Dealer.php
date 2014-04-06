<?php

namespace FattyServer\Card;

use FattyServer\Player\Player;
use FattyServer\Table\Table;


class Dealer extends CardStorage
{
    const RULE_CARDS_HAND = 3;
    const RULE_CARDS_UP = 3;
    const RULE_CARDS_DOWN = 3;

    /**
     * Construct
     */
    function __construct()
    {
        parent::__construct(self::generateCards());
    }

    /**
     * Deals Cards for each Player at the given Table
     *
     * @param Table $table
     */
    public function dealForTable(Table $table)
    {
        $players = $table->getPlayers();

        foreach ($players as $conn) {
            /** @var Player $player */
            $player = $players[$conn];
            $player->getCardsDown()->addCards($this->randomPick(self::RULE_CARDS_DOWN));
            $player->getCardsUp()->addCards($this->randomPick(self::RULE_CARDS_UP));
            $player->getCardsHand()->addCards($this->randomPick(self::RULE_CARDS_UP));
        }
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