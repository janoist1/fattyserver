<?php

namespace FattyServer\Packet\Input;

use FattyServer\Card\Dealer;
use FattyServer\FattyConnection;
use FattyServer\Handler\Packet\PacketHandlerInterface;
use FattyServer\Handler\Packet\SwapHandler;
use FattyServer\Packet\Output\PacketPropagator;
use FattyServer\Player\PlayerManager;
use FattyServer\Table\TableManager;


class Swap implements PacketHandlerInterface
{
    /**
     * @var array
     */
    protected $cardsUp;

    /**
     * @param array $data
     * @throws \Exception
     */
    function __construct(array $data = null)
    {
        if (!is_array($data)) {
            throw new \Exception('Invalid Swap packet');
        }
        if (!array_key_exists('cards_up', $data)) {
            throw new \Exception('Swap cards_up missing');
        }
        if (count($data['cards_up']) != Dealer::RULE_CARDS_UP) {
            throw new \Exception('Swap cards_up incorrect number');
        }

        $this->cardsUp = $data['cards_up'];
    }

    /**
     * @return array
     */
    public function getCardsUp()
    {
        return $this->cardsUp;
    }

    /**
     * {@inheritdoc}
     */
    public function getHandler(
        PlayerManager $playerManager,
        TableManager $tableManager,
        PacketPropagator $propagator,
        FattyConnection $connection)
    {
        return new SwapHandler(
            $playerManager,
            $tableManager,
            $propagator,
            $connection,
            $this
        );
    }
} 