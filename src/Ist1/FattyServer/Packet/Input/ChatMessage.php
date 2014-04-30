<?php

namespace FattyServer\Packet\Input;

use FattyServer\FattyConnection;
use FattyServer\Handler\Connection\Packet\ChatMessageHandler;
use FattyServer\Handler\Connection\ConnectionHandlerInterface;
use FattyServer\Packet\Output\PacketPropagator;
use FattyServer\Player\PlayerManager;
use FattyServer\Table\TableManager;


class ChatMessage implements ConnectionHandlerInterface
{

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
     * {@inheritdoc}
     */
    public function getHandler(
        PlayerManager $playerManager,
        TableManager $tableManager,
        PacketPropagator $propagator,
        FattyConnection $connection)
    {
        return new ChatMessageHandler(
            $playerManager,
            $tableManager,
            $propagator,
            $connection,
            $this
        );
    }
} 