<?php

namespace FattyServer\Packet\Input;

use FattyServer\FattyServerProtocol;
use FattyServer\Handler\ChatMessageHandler;


class ChatMessage implements InputPacketInterface {

    /**
     * @var string
     */
    protected $text;

    /**
     * @param array $data
     * @throws \Exception
     */
    function __construct(array $data = null)
    {
        if (!is_array($data)) {
            throw new \Exception('Invalid ChatMessage packet');
        }

        if (!array_key_exists('text', $data)) {
            throw new \Exception('ChatMessage text missing');
        }

        $this->text = $data['text'];
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->text;
    }

    /**
     * @return ChatMessageHandler
     */
    public function getHandler()
    {
        return new ChatMessageHandler($this);
    }
} 