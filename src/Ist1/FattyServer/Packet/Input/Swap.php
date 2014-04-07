<?php

namespace FattyServer\Packet\Input;

use FattyServer\Card\Dealer;
use FattyServer\Handler\SwapHandler;


class Swap implements InputPacketInterface
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
     * @return SwapHandler
     */
    public function getHandler()
    {
        return new SwapHandler($this);
    }
} 