<?php

namespace FattyServer\Handler;

use FattyServer\Card\Dealer;
use FattyServer\FattyConnection;
use FattyServer\FattyServerProtocol;
use FattyServer\Packet\Input;
use FattyServer\Packet\Output;


class PutCardHandler implements HandlerInterface
{
    /**
     * @var Input\PutCard
     */
    protected $packet;

    /**
     * @param Input\PutCard $packet
     */
    function __construct(Input\PutCard $packet)
    {
        $this->packet = $packet;
    }

    /**
     * Handles PutCard card request.
     *
     * @param FattyConnection $fattyConnFrom
     * @param FattyServerProtocol $serverProtocol
     */
    public function handle(FattyConnection $fattyConnFrom, FattyServerProtocol $serverProtocol)
    {
        $player = $serverProtocol->getPlayerManager()->getPlayer($fattyConnFrom);
        $table = $serverProtocol->getTableManager()->getTableByConnection($fattyConnFrom);

        $cardsHandCount = $player->getCardsHand()->count();

        if ($cardsHandCount || $player->getCardsUp()->count()) {
            $cardIds = $this->packet->getCards();
            $cardStorage = $cardsHandCount ? $player->getCardsHand() : $player->getCardsUp();
            $cardValue = $cardStorage->getById($cardIds[0])->getValue();

            $player->getCardsHand()->removeByIds($cardIds);

        } else {
            $card = $player->getCardsDown()->randomPick(1);
            $cardIds = array($card->getId());
            $cardValue = $card->getValue();
        }

        switch ($cardValue) {
            case Dealer::RULE_2_VALUE:
                break;

            case Dealer::RULE_8_VALUE:
                break;

            case Dealer::RULE_9_VALUE:
                break;

            case Dealer::RULE_10_VALUE:
                break;

            case Dealer::RULE_ACE_VALUE:
                break;

            default:
                break;
        }

        $serverProtocol->getPropagator()->sendPacketToTable(
            new Output\PutCard($player, $cardIds),
            $table
        );
    }
} 