<?php

namespace FattyServer\Handler;


use FattyServer\FattyConnection;
use FattyServer\FattyServerProtocol;

interface HandlerInterface {

    public function handle(FattyConnection $fattyConnection, FattyServerProtocol $serverProtocol);
} 