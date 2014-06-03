<?php

namespace FattyServer;

use FattyServer\Exception\AbstractGameException;
use FattyServer\Handler\Connection\ConnectionCloseHandler;
use FattyServer\Handler\Connection\ConnectionOpenHandler;
use FattyServer\Handler\Connection\PlayerLeftHandler;
use FattyServer\Packet\Input\InputPacketMapper;
use FattyServer\Packet\Output\PacketPropagator;
use FattyServer\Player\PlayerManager;
use FattyServer\Table\TableManager;
use Ratchet\Wamp\JsonException;


/**
 * Fatty Messaging Protocol
 *
 * +--------------------+----+------------------+
 * | Message Type       | ID | DIRECTION        |
 * |--------------------+----+------------------+
 * | WELCOME            | 0  | Server-to-Client |
 * | LOGIN              | 1  | Bi-Directional   |
 * | PLAYERS_LIST       | 9  | Server-to-Client |
 * | TABLES_LIST        | 12 | Server-to-Client |
 * | NEW_PLAYER         | 3  | Server-to-Client |
 * | NEW_TABLE          | 22 | Server-to-Client |
 * | SIT_DOWN           | 13 | Bi-Directional   |
 * | GATHERING          | 2  | Server-to-Client |
 * | PLAYER_READY       | 11 | Bi-Directional   |
 * | PLAYER_NOT_READY   | 21 | Bi-Directional   |
 * | GAME_START         | 4  | Server-to-Client |
 * | SWAP               | 15 | Bi-Directional   |
 * | SWAP_DONE          | 16 | Server-to-Client |
 * | PUT_CARD           | 6  | Bi-Directional   |
 * | TURN               | 17 | Server-to-Client |
 * | PLAYER_WON         | 7  | Server-to-Client |
 * | GAME_END           | 8  | Server-to-Client |
 * | CHAT_MESSAGE       | 10 | Bi-Directional   |
 * | PLAYER_LEFT        | 14 | Bi-Directional   |
 * | PLAYER_LEFT_TABLE  | 18 | Server-to-Client |
 * | TABLE_CLOSED       | 23 | Server-to-Client |
 * | GAME_ERROR         | 19 | Server-to-Client |
 * | TABLE_READY        | 20 | Server-to-Client |
 * | TABLE_RESET        | 24 | Server-to-Client |
 * | RULE_VIOLATION     | 25 | Server-to-Client |
 * +--------------------+----+------------------+
 */
class FattyServerProtocol implements FattyComponentInterface
{
    const PACKET_WELCOME = 0;
    const PACKET_LOGIN = 1;
    const PACKET_PLAYERS_LIST = 9;
    const PACKET_TABLES_LIST = 12;
    const PACKET_NEW_PLAYER = 3;
    const PACKET_NEW_TABLE = 22;
    const PACKET_SIT_DOWN = 13;
    const PACKET_GATHERING = 2;
    const PACKET_PLAYER_READY = 11;
    const PACKET_PLAYER_NOT_READY = 21;
    const PACKET_GAME_START = 4;
    const PACKET_SWAP = 15;
    const PACKET_SWAP_DONE = 16;
    const PACKET_PUT_CARD = 6;
    const PACKET_TURN = 17;
    const PACKET_PLAYER_WON = 7;
    const PACKET_GAME_END = 8;
    const PACKET_CHAT_MESSAGE = 10;
    const PACKET_PLAYER_LEFT = 14;
    const PACKET_PLAYER_LEFT_TABLE = 18;
    const PACKET_TABLE_CLOSED = 23;
    const PACKET_GAME_ERROR = 19;
    const PACKET_TABLE_READY = 20;
    const PACKET_TABLE_RESET = 24;
    const PACKET_RULE_VIOLATION = 25;


    /**
     * @var FattyServer
     */
    protected $server;

    /**
     * @var PlayerManager
     */
    protected $playerManager;

    /**
     * @var TableManager
     */
    protected $tableManager;

    /**
     * @var PacketPropagator
     */
    protected $propagator;

    /**
     * Construct.
     */
    public function __construct(FattyServer $srv)
    {
        $this->server = $srv;
        $this->playerManager = new PlayerManager();
        $this->tableManager = new TableManager();
        $this->propagator = new PacketPropagator($this->playerManager, $this->tableManager);
    }

    /**
     * {@inheritdoc}
     */
    public function onOpen(FattyConnection $fattyConn)
    {
        $handler = new ConnectionOpenHandler(
            $this->playerManager,
            $this->tableManager,
            $this->propagator,
            $fattyConn
        );
        $handler->handle();
    }

    /**
     * @param FattyConnection $fattyConnFrom
     * @param $data string
     * @return void
     * @throws \Ratchet\Wamp\JsonException
     * @throws \UnexpectedValueException
     */
    public function onMessage(FattyConnection $fattyConnFrom, $data)
    {
        if (null === ($json = @json_decode($data, true))) {
            throw new JsonException;
        }

        $packet = InputPacketMapper::map($json);

        try {
            $packet->getHandler(
                $this->playerManager,
                $this->tableManager,
                $this->propagator,
                $fattyConnFrom
            )->handle();
        } catch (AbstractGameException $exception) {
            $exception->getHandler(
                $this->playerManager,
                $this->tableManager,
                $this->propagator
            )->handle();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function onClose(FattyConnection $fattyConn)
    {
        try {
            $handler = new PlayerLeftHandler(
                $this->playerManager,
                $this->tableManager,
                $this->propagator,
                $fattyConn
            );
            $handler->handle();
        } catch (\Exception $e) {
            // todo: create more specific exception...
        }

        $handler = new ConnectionCloseHandler(
            $this->playerManager,
            $this->tableManager,
            $this->propagator,
            $fattyConn
        );
        $handler->handle();
    }

    /**
     * {@inheritdoc}
     */
    public function onError(FattyConnection $conn, \Exception $e)
    {
        //return $this->_decorating->onError($this->connections[$conn], $e);
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }

    /**
     * @return \FattyServer\Player\PlayerManager
     */
    public function getPlayerManager()
    {
        return $this->playerManager;
    }

    /**
     * @return \FattyServer\Packet\Output\PacketPropagator
     */
    public function getPropagator()
    {
        return $this->propagator;
    }

    /**
     * @return \FattyServer\FattyServer
     */
    public function getServer()
    {
        return $this->server;
    }

    /**
     * @return \FattyServer\Table\TableManager
     */
    public function getTableManager()
    {
        return $this->tableManager;
    }
}