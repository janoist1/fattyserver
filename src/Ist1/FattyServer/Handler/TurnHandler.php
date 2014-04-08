<?php

namespace FattyServer\Handler;

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
        $player = $serverProtocol->getPlayerManager()->getPlayer($fattyConnFrom);
        $table = $serverProtocol->getTableManager()->getTableByConnection($fattyConnFrom);

        $burn = false;
        $cardsHandCount = $player->getCardsHand()->count();

        if ($cardsHandCount || $player->getCardsUp()->count()) {
            $cardIds = $this->packet->getCards();
            $cardStorage = $cardsHandCount ? $player->getCardsHand() : $player->getCardsUp();
            $cardValue = $cardStorage->getById($cardIds[0])->getValue();

            $player->getCardsHand()->removeByIds($cardIds);

            if (count($cardIds) == Dealer::RULE_BURN_NUM) {
                $burn = count($cardIds) == Dealer::RULE_BURN_NUM;
            }

        } else {
            $card = $player->getCardsDown()->randomPick(1);
            $cardIds = array($card->getId());
            $cardValue = $card->getValue();
        }

        if (!$burn) {
            $table->getDealer()->turn($cardValue);
        }

        $serverProtocol->getPropagator()->sendPacketToTable(
            new Output\PutCard($player, $cardIds),
            $table
        );
        $serverProtocol->getPropagator()->sendPacketToTable(
            new Output\Tu($player, $cardIds),
            $table
        );
    }
} 