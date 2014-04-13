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
        $fattyConn = new FattyConnection($conn);
        $this->connections->attach($conn, $fattyConn);
        $this->fattyProtocol->onOpen($fattyConn);
    }

    /**
     * {@inheritdoc}
     */
    public function onMessage(ConnectionInterface $conn, $msg)
    {
        try {
            /** @var FattyConnection $fattyConn */
            $fattyConn = $this->connections->offsetGet($conn);
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
        /** @var FattyConnection $fattyConn */
        $fattyConn = $this->connections->offsetGet($conn);
        $this->fattyProtocol->onClose($fattyConn);
        $this->connections->detach($conn);
    }

    /**
     * {@inheritdoc}
     */
    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        /** @var FattyConnection $fattyConn */
        $fattyConn = $this->connections->offsetGet($conn);
        $this->fattyProtocol->onError($fattyConn, $e);
    }

    /**
     * @return \SplObjectStorage
     */
    public function getConnections()
    {
        return $this->connections;
    }
}