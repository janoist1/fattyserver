<?php

namespace FattyServer\Handler;

use FattyServer\FattyConnection;
use FattyServer\FattyServerProtocol;
use FattyServer\Packet\Input\ChatMessage as ChatMessageIn;
use FattyServer\Packet\Output\ChatMessage as ChatMessageOut;


class ChatMessageHandler implements HandlerInterface
{
    /**
     * @var ChatMessageIn
     */
    protected $packet;

    /**
     * @param ChatMessageIn $packet
     */
    function __construct(ChatMessageIn $packet)
    {
        $this->packet = $packet;
    }

    /**
     * Handles chat message.
     *
     * @param FattyConnection $fattyConnFrom
     * @param FattyServerProtocol $serverProtocol
     */
    public function handle(FattyConnection $fattyConnFrom, FattyServerProtocol $serverProtocol)
    {
        $player = $serverProtocol->getPlayerManager()->getPlayers()->getOne($fattyConnFrom);

        $serverProtocol->getPropagator()->sendPacketToPlayers(
            new ChatMessageOut($player, $this->packet->getMessage())
        );
    }
} 