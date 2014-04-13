<?php

namespace FattyServer;

use FattyServer\Packet\Input\InputPacketMapper;
use FattyServer\Packet\Output\PacketPropagator;
use FattyServer\Player\PlayerManager;
use FattyServer\Table\TableManager;
use Ratchet\Wamp\JsonException;
use Ratchet\ConnectionInterface;


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
 * | SIT_DOWN           | 13 | Bi-Directional   |
 * | GATHERING          | 2  | Server-to-Client |
 * | PLAYER_READY       | 11 | Bi-Directional   |
 * | GAME_START         | 4  | Server-to-Client |
 * | SWAP               | 15 | Bi-Directional   |
 * | SWAP_DONE          | 16 | Server-to-Client |
 * | PUT_CARD           | 6  | Bi-Directional   |
 * | TURN               | 17 | Server-to-Client |
 * | PLAYER_WON         | 7  | Server-to-Client |
 * | GAME_END           | 8  | Server-to-Client |
 * | CHAT_MESSAGE       | 10 | Bi-Directional   |
 * +--------------------+----+------------------+
 */
class FattyServerProtocol implements FattyComponentInterface
{
    const MSG_WELCOME = 0;
    const MSG_LOGIN = 1;
    const MSG_PLAYERS_LIST = 9;
    const MSG_TABLES_LIST = 12;
    const MSG_NEW_PLAYER = 3;
    const MSG_SIT_DOWN = 13;
    const MSG_GATHERING = 2;
    const MSG_PLAYER_READY = 11;
    const MSG_GAME_START = 4;
    const MSG_SWAP = 15;
    const MSG_SWAP_DONE = 16;
    const MSG_PUT_CARD = 6;
    const MSG_TURN = 17;
    const MSG_PLAYER_WON = 7;
    const MSG_GAME_END = 8;
    const MSG_CHAT_MESSAGE = 10;


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
    public function onOpen(ConnectionInterface $conn)
    {
        echo "Connection {$conn->resourceId} has connected\n";
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
        $packet->getHandler()->handle($fattyConnFrom, $this);
    }

    /**
     * {@inheritdoc}
     */
    public function onClose(ConnectionInterface $conn)
    {
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    /**
     * {@inheritdoc}
     */
    public function onError(ConnectionInterface $conn, \Exception $e)
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