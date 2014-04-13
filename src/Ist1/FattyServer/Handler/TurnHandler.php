<?php

namespace FattyServer\Handler;

use FattyServer\Card\CardStorage;
use FattyServer\Card\Dealer;
use FattyServer\FattyConnection;
use FattyServer\FattyServerProtocol;
use FattyServer\Packet\Input;
use FattyServer\Packet\Output;


class TurnHandler implements HandlerInterface
{
    /**
     * @var Input\Turn
     */
    protected $packet;

    /**
     * @param Input\Turn $packet
     */
    function __construct(Input\Turn $packet)
    {
        $this->packet = $packet;
    }

    /**
     * Handles Turn card request.
     *
     * @param FattyConnection $fattyConnFrom
     * @param FattyServerProtocol $serverProtocol
     */
    public function handle(FattyConnection $fattyConnFrom, FattyServerProtocol $serverProtocol)
    {
        $player = $serverProtocol->getPlayerManager()->getPlayers()->getOne($fattyConnFrom);
        $table = $serverProtocol->getTableManager()->getTableByConnection($fattyConnFrom);
        $nextPlayer = $player;

        $cardsPickIds = array();
        $cardsHandCount = $player->getCardsHand()->count();

        if ($cardsHandCount || $player->getCardsUp()->count()) {
            // player has cards in hand or upside-up on the table
            $cardsPutIds = $this->packet->getCards();
            $cardStorage = $cardsHandCount ? $player->getCardsHand() : $player->getCardsUp();
            $cardValue = $cardStorage->getById($cardsPutIds[0])->getValue();

            if (Dealer::checkPass($cardValue, $table->getCards()->getLastCard()->getValue())) { // todo: implement the 8 rule
                // card passed, player picks from the deck if there are any
                $cardStorage->transferByIdsTo($cardsPutIds, $table->getCards());

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
            // if the player has cards only upside down on the table (3 random cards)
            $card = reset($player->getCardsDown()->randomPick(1));
            $cardsPutIds = array($card->getId());
            $cardValue = $card->getValue();

            if (Dealer::checkPass($cardValue, $table->getCards()->getLastCard()->getValue())) {
                $table->getCards()->add($card);
            } else {
                $player->getCardsHand()->add($card);
                $cardsPickIds = array($card->getId());
            }
        }

        $burn = Dealer::checkBurn($cardValue, $table->getCards());

        if ($burn) {
            $table->getCards()->removeAll();
        } elseif ($cardValue == Dealer::RULE_ACE_VALUE) {
            $nextPlayer = $table->getPlayers()->getById($this->packet->getPlayerId());
        } else {
            $nextPlayer = $table->turn()->getCurrentPlayer();
        }

        $serverProtocol->getPropagator()->sendPacketToTable(
            new Output\Turn($nextPlayer, $cardsPutIds, $cardsPickIds, $burn),
            $table
        );

        // if the next Player is unable to put a valid card, has to pick up all
        $cardStorage = $nextPlayer->getCardsHand()->count()
            ? $nextPlayer->getCardsHand()
            : $nextPlayer->getCardsUp();

        if (!Dealer::checkCardsPass($cardStorage, $cardValue)) {
            $cardsPickIds = $table->getCards()->getIds();
            $table->getCards()->transferAllTo($nextPlayer->getCardsHand());

            $serverProtocol->getPropagator()->sendPacketToTable(
                new Output\Turn($nextPlayer, null, $cardsPickIds, false),
                $table
            );
        }
    }
} 