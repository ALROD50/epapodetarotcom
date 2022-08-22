<?php
date_default_timezone_set("Brazil/East");
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use Novasystemschat\Socket\Chat;

require 'vendor/autoload.php';

// Conect Server
$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new Chat()
        )
    ),
    8787
);
$server->run();