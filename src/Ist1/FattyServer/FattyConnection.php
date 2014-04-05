<?php

namespace FattyServer;

use FattyServer\Packet\Output\AbstractOutputPacket;
use FattyServer\Packet\Output\Welcome;
use Ratchet\AbstractConnectionDecorator;
use Ratchet\ConnectionInterface;


class FattyConnection extends AbstractConnectionDecorator
{
    /**
     * @var string
     */
    protected $id;

    /**
     * {@inheritdoc}
     */
    public function __construct(ConnectionInterface $conn)
    {
        parent::__construct($conn);

        $this->id = uniqid();

        $this->sendPacket(new Welcome(
            $this->id,
            \FattyServer\VERSION
        ));
    }

    /**
     * Sends a packet to the client.
     *
     * @param AbstractOutputPacket $packet
     * @return $this
     */
    public function sendPacket(AbstractOutputPacket $packet)
    {
        $this->send($packet->__toString());

        return $this;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @internal
     */
    public function send($data)
    {
        $this->getConnection()->send($data);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function close($opt = null)
    {
        $this->getConnection()->close($opt);
    }
}