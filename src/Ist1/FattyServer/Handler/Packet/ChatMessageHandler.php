<?php

namespace FattyServer\Handler\Packet;

use FattyServer\FattyConnection;
use FattyServer\Handler\AbstractHandler;
use FattyServer\Packet\Input;
use FattyServer\Packet\Output;
use FattyServer\Packet\Output\PacketPropagator;
use FattyServer\Player\PlayerManager;
use FattyServer\Table\TableManager;


class ChatMessageHandler extends AbstractHandler
{
    /**
     * @var Input\ChatMessage
     */
    protected $packet;

    /**
     * @param PlayerManager $playerManager
     * @param TableManager $tableManager
     * @param PacketPropagator $propagator
     * @param FattyConnection $connection
     * @param Input\ChatMessage $packet
     */
    function __construct(
        PlayerManager $playerManager,
        TableManager $tableManager,
        PacketPropagator $propagator,
        FattyConnection $connection,
        Input\ChatMessage $packet)
    {
        parent::__construct(
            $playerManager,
            $tableManager,
            $propagator,
            $connection
        );

        $this->packet = $packet;
    }

    /**
     * Handles chat message.
     */
    public function handle()
    {
        $player = $this->playerManager->getPlayers()->getOne($this->connection);

        $this->propagator->sendPacketToPlayers(
            new Output\ChatMessage($player, $this->packet->getMessage())
        );
    }
} 