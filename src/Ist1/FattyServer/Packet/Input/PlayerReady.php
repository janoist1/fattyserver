<?php

namespace FattyServer\Packet\Input;

use FattyServer\Handler\PlayerReadyHandler;


class PlayerReady implements InputPacketInterface {

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
     * @return PlayerReadyHandler
     */
    public function getHandler()
    {
        return new PlayerReadyHandler($this);
    }
} 