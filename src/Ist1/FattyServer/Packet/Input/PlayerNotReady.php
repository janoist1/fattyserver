<?php

namespace FattyServer\Packet\Input;

use FattyServer\Handler\PlayerNotReadyHandler;


class PlayerNotReady implements InputPacketInterface {

    /**
     * @param array $data
     * @throws \Exception
     */
    function __construct(array $data = null)
    {
        if ($data !== null) {
            throw new \Exception('Invalid PlayerNotReady packet');
        }
    }

    /**
     * @return PlayerNotReadyHandler
     */
    public function getHandler()
    {
        return new PlayerNotReadyHandler($this);
    }
} 