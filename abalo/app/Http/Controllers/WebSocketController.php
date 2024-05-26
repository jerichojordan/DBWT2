<?php

namespace App\Http\Controllers;

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use App\WebSocketServer;

class WebSocketController extends Controller
{
    public function index()
    {
        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new WebSocketServer()
                )
            ),
            8080 // Use the desired port number
        );

        $server->run();
    }
}
