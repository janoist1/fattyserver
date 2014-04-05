<?php

namespace FattyServer;

use Ratchet\ComponentInterface;

interface FattyComponentInterface extends ComponentInterface
{
    /**
     * @param FattyConnection $from
     * @param $msg
     * @return mixed
     */
    function onMessage(FattyConnection $from, $msg);
}
