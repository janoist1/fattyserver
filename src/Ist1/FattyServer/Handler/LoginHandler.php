<?php

namespace FattyServer\Handler;

use FattyServer\FattyConnection;
use FattyServer\FattyServerProtocol;
use FattyServer\Packet\Input\Login as LoginIn;
use FattyServer\Packet\Output\Login as LoginOut;
use FattyServer\Packet\Output\NewPlayer;
use FattyServer\Packet\Output\PlayersList;
use FattyServer\Packet\Output\TablesList;


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
     * @param FattyServerProtocol $serverProtocol
     */
    public function handle(FattyConnection $fattyConnFrom, FattyServerProtocol $serverProtocol)
    {
        $player = $serverProtocol->getPlayerManager()->createAndAddPlayer(
            $fattyConnFrom, $this->packet->getName()
        );
        $tables = $serverProtocol->getTableManager()->getTables();

        $fattyConnFrom->sendPacket(new LoginOut());
        $fattyConnFrom->sendPacket(new TablesList($tables));
        $fattyConnFrom->sendPacket(
            new PlayersList($serverProtocol->getPlayerManager()->getPlayers())
        );
        $serverProtocol->getPropagator()->sendPacketToPlayers(
            new NewPlayer($player),
            $fattyConnFrom
        );
    }
} 