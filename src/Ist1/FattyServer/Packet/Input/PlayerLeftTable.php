<?php

namespace FattyServer\Packet\Input;

use FattyServer\Handler\LoginHandler;
use FattyServer\Handler\PlayerReadyHandler;


class PlayerLeftTable implements InputPacketInterface {

    /**
     * @param array $data
     * @throws \Exception
     */
    function __construct(array $data = null)
    {
        if ($data !== null) {
            throw new \Exception('Invalid PlayerReady packet');
        }
    }

    /**
     * @return LoginHandler
     */
    public function getHandler()
    {
        return new PlayerReadyHandler($this);
    }
} 