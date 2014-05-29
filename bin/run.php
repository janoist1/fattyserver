<?php

use FattyServer\FattyServerFactory;

require dirname(__DIR__) . '/vendor/autoload.php';

$port = 9991;

echo "Server starting on port $port...\n";

$server = FattyServerFactory::make($port);
$server->run();