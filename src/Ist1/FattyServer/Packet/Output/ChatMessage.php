<?php

namespace FattyServer\Packet\Output;

use FattyServer\FattyServerProtocol;
use FattyServer\Player\Player;


class ChatMessage extends AbstractOutputPacket
{
    /**
     * @var Player
     */
    protected $player;

    /**
     * @var string
     */
    protected $text;

    /**
     * @var int
     */
    protected $timestamp;

    /**
     * @param $text
     */
    function __construct(Player $player, $text)
    {
        $this->player = $player;
        $this->text = $text;
        $this->timestamp = time();
    }

    /**
     * @return array
     */
    public function getData()
    {
        $data = array(
            'player_id' => $this->player->getId(),
            'text' => $this->text,
            'timestamp' => $this->timestamp
        );

        return $data;
    }

    /**
     * @return int
     */
    public function getType()
    {
        return FattyServerProtocol::MSG_CHAT_MESSAGE;
    }
} 