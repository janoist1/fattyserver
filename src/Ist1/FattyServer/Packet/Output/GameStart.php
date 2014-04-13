<?php

namespace FattyServer\Packet\Output;

use FattyServer\Card\Dealer;
use FattyServer\FattyServerProtocol;
use FattyServer\Player\Player;
use FattyServer\Table\Table;


class GameStart extends AbstractOutputPacket
{
    /**
     * @var Player
     */
    protected $player;

    /**
     * @var Table
     */
    protected $table;

    /**
     * @param Player $player
     * @param Table $table
     */
    function __construct(Player $player, Table $table)
    {
        $this->player = $player;
        $this->table = $table;
    }

    /**
     * @return array
     */
    public function getData()
    {
        $cards = array();
        $players = $this->table->getPlayers()->getAll();

        foreach ($players as $conn) {
            /** @var Player $player */
            $player = $players[$conn];
            $cards[$player->getId()] = array(
                'cards_hand' => $player == $this->player
                    ? $player->getCardsHand()->getIds()
                    : array_keys(Dealer::generateDummy($player->getCardsHand()->count())),
                'cards_up' => $player->getCardsUp()->getIds(),
                'cards_down' => array_keys(Dealer::generateDummy($player->getCardsDown()->count())),
            );
        }

        return array(
            'cards' => $cards
        );
    }

    /**
     * @return int
     */
    public function getType()
    {
        return FattyServerProtocol::MSG_GAME_START;
    }
} 