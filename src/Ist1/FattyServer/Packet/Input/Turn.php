<?php

namespace FattyServer\Packet\Input;

use FattyServer\Handler\TurnHandler;


class Turn implements InputPacketInterface
{
    /**
     * @var array
     */
    protected $cards;

    /**
     * @var string
     */
    protected $player_id;

    /**
     * @param array $data
     * @throws \Exception
     */
    function __construct(array $data = null)
    {
        if (!is_array($data)) {
            throw new \Exception('Invalid Turn packet');
        }
        if (!array_key_exists('cards', $data)) {
            throw new \Exception('Turn cards missing');
        }

        $this->cards = $data['cards'];

        if (array_key_exists('player_id', $data)) {
            $this->player_id = $data['player_id'];
        }
    }

    /**
     * @return array
     */
    public function getCards()
    {
        return $this->cards;
    }

    /**
     * @return string
     */
    public function getPlayerId()
    {
        return $this->player_id;
    }

    /**
     * @return TurnHandler
     */
    public function getHandler()
    {
        return new TurnHandler($this);
    }
} 