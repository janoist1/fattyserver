<?php

namespace FattyServer\Handler\Connection\Packet;

use FattyServer\Card\Dealer;
use FattyServer\Exception\RuleViolation\CardNotValidException;
use FattyServer\Exception\RuleViolation\PlayerNotValidException;
use FattyServer\FattyConnection;
use FattyServer\Handler\Connection\AbstractConnectionHandler;
use FattyServer\Packet\Input;
use FattyServer\Packet\Output;
use FattyServer\Packet\Output\PacketPropagator;
use FattyServer\Player\PlayerManager;
use FattyServer\Table\TableManager;


class TurnHandler extends AbstractConnectionHandler
{
    /**
     * @var Input\Turn
     */
    protected $packet;

    /**
     * @param PlayerManager $playerManager
     * @param TableManager $tableManager
     * @param PacketPropagator $propagator
     * @param FattyConnection $connection
     * @param Input\Turn $packet
     */
    function __construct(
        PlayerManager $playerManager,
        TableManager $tableManager,
        PacketPropagator $propagator,
        FattyConnection $connection,
        Input\Turn $packet)
    {
        parent::__construct(
            $playerManager,
            $tableManager,
            $propagator,
            $connection
        );

        $this->packet = $packet;
    }

    /**
     * Handles Turn card request.
     */
    public function handle()
    {
        // todo: split this huge function

        $player = $this->playerManager->getPlayers()->getOne($this->connection);
        $table = $this->tableManager->getTableByPlayer($player);

        if (!$table->hasPlayer($player)) {
            // todo: handle Player is not playing
            return;
        }
        if ($table->getActivePlayer() != $player) {
            // todo: handle wrong turn
            return;
        }

        $cardsPutIds = array();
        $cardsPickIds = array();
        $cardsHandCount = $player->getCardsHand()->count();

        if ($cardsHandCount || $player->getCardsUp()->count()) {
            // player has cards in hand or face-up on the table
            $cardsPutIds = $this->packet->getCards();
            $cardStorage = $cardsHandCount ? $player->getCardsHand() : $player->getCardsUp();
            $card = $cardStorage->getById($cardsPutIds[0]);

            // todo: check if cards to put are in the storage
            if (!$cardStorage->hasIds($cardsPutIds)) {
                throw new CardNotValidException($player);
            }
            if (!Dealer::checkPass($card, $table->getCards())) {
                throw new CardNotValidException($player);
            }

            if (Dealer::checkPass($card, $table->getCards())) {
                // card passed, transfer cards to the table
                $cardStorage->transferByIdsTo($cardsPutIds, $table->getCards());

                // pick from the deck if there is any
                if ($table->getDealer()->getCards()->count()) {
                    $cardsPick = $table->getDealer()->getCards()
                        ->randomPick(max(Dealer::RULE_CARDS_HAND - $player->getCardsHand()->count(), 0));
                    $cardsPickIds = array_keys($cardsPick);

                    $player->getCardsHand()->addArray($cardsPick);
                }
            } else {
                // card did not pass, player has to pick all the cards from the table, but not here ... todo
            }
        } else {
            // if the player has cards only face-down on the table (3 random cards)
            $card = reset($player->getCardsDown()->randomPick(1));

            if (Dealer::checkPass($card, $table->getCards())) {
                // the Player can put the randomly picket card
                $table->getCards()->add($card);
                $cardsPutIds = array($card->getId());

                // todo: check if user has any cards left, unless win
            } else {
                // the Player has to pick up the random card
                $player->getCardsHand()->add($card);
                $cardsPickIds = array($card->getId());
            }
        }

        // let's get the next Player
        $nextPlayer = null;
        $burn = Dealer::checkBurn($card, $table->getCards());

        if ($burn) {
            $table->getCards()->removeAll();

            if (!$table->isPlayerFinished($player)) {
                // Player burned but hasn't finished playing
                $nextPlayer = $player;
            }
        } elseif ($card->getValue() == Dealer::RULE_ACE_VALUE) {
            // Player has an Ace so can choose the next one
            $nextPlayer = $table->getPlayers()->getById($this->packet->getPlayerId());

            if ($nextPlayer == null) {
                throw new PlayerNotValidException($player);
            }
            if ($nextPlayer == $player) {
                throw new PlayerNotValidException($player);
            }
            if ($table->isPlayerFinished($nextPlayer)) {
                throw new PlayerNotValidException($player);
            }
        }
        if ($nextPlayer === null) {
            // nothing special, next Player in the row turns
            $nextPlayer = $table->turn()->getActivePlayer();
        }

        // send Turn packet with next Player, put cards, newly picket cards to the current Player
        $this->connection->sendPacket(
            new Output\Turn($nextPlayer, $cardsPutIds, $cardsPickIds, $burn)
        );

        // send Turn packet with next Player, put cards, newly picket dummy cards to all other Players
        $this->propagator->sendPacketToTable(
            new Output\Turn($nextPlayer, $cardsPutIds, array_keys(Dealer::generateDummy(count($cardsPickIds))), $burn),
            $table,
            $this->connection
        );

        // if the next Player is still playing
        if (!$table->isPlayerLeft($nextPlayer)) {
            $cardStorage = $nextPlayer->getCardsHand()->count()
                ? $nextPlayer->getCardsHand()
                : $nextPlayer->getCardsUp();

            // if the next Player is unable to put a valid card, has to pick up all
            if (!Dealer::checkAnyPass($cardStorage, $table->getCards())) {
                $cardsPickIds = $table->getCards()->getIds();
                $table->getCards()->transferAllTo($nextPlayer->getCardsHand());

                $nextPlayer = $table->turn()->getActivePlayer();

                $this->propagator->sendPacketToTable(
                    new Output\Turn($nextPlayer, null, $cardsPickIds, false),
                    $table
                );
            }
        }

        // we put a card instead of the players who left
        while (!$nextPlayer->isConnected()
            || ($table->isPlayerLeft($nextPlayer)) && !$table->isPlayerFinished($nextPlayer)) {
            // get the first available card set
            switch (true) {
                case $nextPlayer->getCardsHand()->count() > 0:
                    $cardStorage = $nextPlayer->getCardsHand();
                    break;

                case $nextPlayer->getCardsUp()->count() > 0:
                    $cardStorage = $nextPlayer->getCardsUp();
                    break;

                case $nextPlayer->getCardsDown()->count() > 0:
                    $cardStorage = $nextPlayer->getCardsDown();
                    break;

                default:
                    // player already won
                    $cardStorage = null;
                    break;
            }

            $cardsPutIds = array();
            $cardsPickIds = array();
            $cardIndex = 0;

            // get the first available card
            while (($card = $cardStorage->getCardAt($cardIndex++)) !== null
                && Dealer::checkPass($card, $table->getCards())) ;

            if ($card != null) {
                // there was valid card to put
                $cardsPutIds = array($card->getId());
                $cardStorage->transferByIdsTo($cardsPutIds, $table->getCards());

                // pick from the deck if there is any
                if ($table->getDealer()->getCards()->count()) {
                    $cardsPick = $table->getDealer()->getCards()
                        ->randomPick(max(Dealer::RULE_CARDS_HAND - $nextPlayer->getCardsHand()->count(), 0));
                    $cardsPickIds = array_keys($cardsPick);

                    $player->getCardsHand()->addArray($cardsPick);
                }

                // todo: check if user has any cards left, unless win
            } else {
                // there was no valid card to put, player has to pick up all
                $cardsPickIds = $table->getCards()->getIds();
                $table->getCards()->transferAllTo($nextPlayer->getCardsHand());
            }

            $nextPlayer = $table->turn()->getActivePlayer();

            $this->propagator->sendPacketToTable(
                new Output\Turn($nextPlayer, $cardsPutIds, $cardsPickIds, false),
                $table,
                $nextPlayer->getConnection()
            );
        }
    }
}