<?php

namespace FattyServer\Packet\Input;

use FattyServer\Handler\HandleableInterface;


interface InputPacketInterface extends HandleableInterface
{
    /**
     * @param array $data
     */
    function __construct(array $data = null);
}