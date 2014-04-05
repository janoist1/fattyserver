<?php
namespace FattyServer;

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

class FattyServerFactory
{
    /**
     * @param $port
     * @return IoServer
     */
    public static function make($port)
    {
        return IoServer::factory(
            new HttpServer(
                new WsServer(
                    new FattyServer()
                )
            ),
            $port
        );
    }
}