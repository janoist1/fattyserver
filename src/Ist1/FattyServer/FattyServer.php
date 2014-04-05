<?php
namespace FattyServer;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Wamp\JsonException;

const VERSION = "Fatty/0.1";


class FattyServer implements MessageComponentInterface
{
    /**
     * @var \SplObjectStorage
     */
    protected $connections;

    /**
     * @var FattyServerProtocol
     */
    protected $fattyProtocol;


    /**
     * Construct
     */
    public function __construct()
    {
        $this->connections = new \SplObjectStorage;
        $this->fattyProtocol = new FattyServerProtocol($this);
    }

    /**
     * {@inheritdoc}
     */
    public function onOpen(ConnectionInterface $conn)
    {
        $this->connections->attach($conn, new FattyConnection($conn));
        $this->fattyProtocol->onOpen($conn);
    }

    /**
     * {@inheritdoc}
     */
    public function onMessage(ConnectionInterface $conn, $msg)
    {
        try {
            /** @var FattyConnection $fattyConn */
            $fattyConn = $this->connections[$conn];
            $this->fattyProtocol->onMessage($fattyConn, $msg);
        } catch (JsonException $je) {
            $conn->close(1007);
        } catch (\UnexpectedValueException $uve) {
            $conn->close(1007);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function onClose(ConnectionInterface $conn)
    {
        $this->connections->detach($conn);
        $this->fattyProtocol->onClose($conn);
    }

    /**
     * {@inheritdoc}
     */
    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        $this->fattyProtocol->onError($conn, $e);
    }

    /**
     * @return \SplObjectStorage
     */
    public function getConnections()
    {
        return $this->connections;
    }

    /**
     * @return PlayerManager
     */
    public function getPlayerManager()
    {
        return $this->playerManager;
    }
}