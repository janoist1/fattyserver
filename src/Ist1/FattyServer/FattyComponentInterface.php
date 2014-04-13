<?php

namespace FattyServer;


interface FattyComponentInterface
{
    /**
     * @param FattyConnection $from
     * @param $msg
     * @return mixed
     */
    function onMessage(FattyConnection $from, $msg);

    /**
     * @param FattyConnection $conn
     */
    function onOpen(FattyConnection $conn);

    /**
     * @param FattyConnection $conn
     */
    function onClose(FattyConnection $conn);

    /**
     * @param  FattyConnection $conn
     * @param  \Exception $e
     * @throws \Exception
     */
    function onError(FattyConnection $conn, \Exception $e);
}
