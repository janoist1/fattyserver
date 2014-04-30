<?php

namespace FattyServer\Handler\Connection;

use FattyServer\Packet\Output\Welcome;


class ConnectionOpenHandler extends AbstractConnectionHandler
{
    /**
     * Handles connection open event.
     */
    public function handle()
    {
        $this->connection->sendPacket(new Welcome(
            $this->connection->getId(),
            \FattyServer\VERSION
        ));

        echo "Connection opened: {$this->connection->getId()}\n";
    }
} 