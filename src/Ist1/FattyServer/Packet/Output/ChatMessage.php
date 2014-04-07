<?php

namespace FattyServer\Packet\Output;

use FattyServer\FattyServerProtocol;
use FattyServer\Player\Player;


class ChatMessage extends AbstractPlayerOutputPacket
{
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
        parent::__construct($player);
        $this->text = $text;
        $this->timestamp = time();
    }

    /**
     * @return array
     */
    public function getData()
    {
        $data = array(
            'text' => $this->text,
            'timestamp' => $this->timestamp
        );

        return array_merge(parent::getData(), $data);
    }

    /**
     * @return int
     */
    public function getType()
    {
        return FattyServerProtocol::MSG_CHAT_MESSAGE;
    }
} 