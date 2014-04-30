<?php

namespace FattyServer\Handler\Connection;


class ConnectionCloseHandler extends AbstractConnectionHandler
{
    /**
     * Handles connection close event.
     */
    public function handle()
    {
        echo "Connection closed: {$this->connection->getId()}\n";
    }
} 