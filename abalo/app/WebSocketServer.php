<?php

namespace App;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class WebSocketServer implements MessageComponentInterface
{
    protected $clients;
    protected $broadcaster;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
        $this->broadcaster = app('pusher'); // Replace with your broadcaster instance
    }

    public function onOpen(ConnectionInterface $connection)
    {
        $this->clients->attach($connection);
    }

    public function onClose(ConnectionInterface $connection)
    {
        $this->clients->detach($connection);
    }

    public function onMessage(ConnectionInterface $from, $message)
    {
        $this->broadcastMessage($message);
    }

    public function onError(ConnectionInterface $connection, \Exception $exception)
    {
        // Handle errors
    }

    public function broadcastMessage($message)
    {
        $this->broadcaster->trigger('channel-name', 'event-name', ['message' => $message]);
    }
}

/*class MyChat implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        echo "Adding new connection\n";
        $this->clients->attach($conn);
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        echo "Received: $msg\n";
        foreach ($this->clients as $client) {
            if ($from != $client) {
                $client->send($msg);
            }
        }
    }

    public function onClose(ConnectionInterface $conn) {
        echo "Closing connection\n";
        $this->clients->detach($conn);
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "Closing connection with errors\n";
        $conn->close();
    }
}

$app = new Ratchet\App('localhost', 8085);
$app->route('/chat', new WebSocketServer(), array('*'));
$app->route('/echo', new Ratchet\Server\EchoServer, array('*'));

echo "Starting WebSocketServer\n";
$app->run();
*/



