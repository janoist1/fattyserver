<?php

namespace FattyServer\Handler;

use FattyServer\FattyConnection;
use FattyServer\FattyServerProtocol;
use FattyServer\Packet\Input\Login as LoginIn;
use FattyServer\Packet\Output\Login as LoginOut;
use FattyServer\Packet\Output\NewPlayer;
use FattyServer\Packet\Output\PlayerList;


class LoginHandler implements HandlerInterface
{
    /**
     * @var LoginIn
     */
    protected $packet;

    /**
     * @param LoginIn $packet
     */
    function __construct(LoginIn $packet)
    {
        $this->packet = $packet;
    }

    /**
     * Handles login request.
     *
     * @param FattyConnection $fattyConnFrom
     */
    public function handle(FattyConnection $fattyConnFrom, FattyServerProtocol $serverProtocol)
    {
        $connections = $serverProtocol->getServer()->getConnections();
        $player = $serverProtocol->getPlayerManager()->createAndAddPlayer(
            $fattyConnFrom, $this->packet->getName()
        );

        $fattyConnFrom->sendPacket(new LoginOut());
        $fattyConnFrom->sendPacket(
            new PlayerList($serverProtocol->getPlayerManager()->getPlayers())
        );

        foreach ($connections as $conn) {
            /** @var FattyConnection $fattyConnTo */
            $fattyConnTo = $connections[$conn];
            if ($fattyConnFrom !== $fattyConnTo) {
                $fattyConnTo->sendPacket(new NewPlayer($player));
            }
        }
    }
} 