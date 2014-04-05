<?php

namespace FattyServer\Packet\Input;

use FattyServer\Handler\HandlerInterface;


interface InputPacketInterface
{
    /**
     * @param array $data
     */
    function __construct(array $data = null);

    /**
     * @return HandlerInterface
     */
    public function getHandler();
}