<?php

namespace FattyServer\Packet\Input;

use FattyServer\Handler\PutCardHandler;


class PutCard implements InputPacketInterface
{
    /**
     * @var string
     */
    protected $card;

    /**
     * @var array
     */
    protected $variants;

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
            throw new \Exception('Invalid PutCard packet');
        }
        if (!array_key_exists('card', $data)) {
            throw new \Exception('PutCard card missing');
        }

        $this->card = $data['card'];
        if (array_key_exists('variants', $data)) {
            $this->variants = $data['variants'];
        }
        if (array_key_exists('player_id', $data)) {
            $this->player_id = $data['player_id'];
        }
    }

    /**
     * @return array
     */
    public function getCard()
    {
        return $this->card;
    }

    /**
     * @return array
     */
    public function getVariants()
    {
        return $this->variants;
    }

    /**
     * @return string
     */
    public function getPlayerId()
    {
        return $this->player_id;
    }

    /**
     * @return array
     */
    public function getCards()
    {
        return array_merge(
            array($this->card),
            is_array($this->variants) ? $this->variants : array()
        );
    }

    /**
     * @return PutCardHandler
     */
    public function getHandler()
    {
        return new PutCardHandler($this);
    }
} 