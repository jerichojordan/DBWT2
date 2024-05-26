<?php

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
require __DIR__ . '/vendor/autoload.php';
class WebSocketServer implements MessageComponentInterface
{
    protected $connections = [];

    public function onOpen(ConnectionInterface $connection)
    {
        $this->connections[] = $connection;
    }

    public function onClose(ConnectionInterface $conn)
    {
        $index = array_search($conn, $this->connections);
        if ($index !== false) {
            unset($this->connections[$index]);
        }
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        //$message = "In Kürze verbessern wir Abalo für Sie!\nNach einer kurzen Pause sind wir wieder für Sie da!\nVersprochen.";
        foreach ($this->connections as $connection) {
            $connection->send($msg);
        }
    }

    public function onError(ConnectionInterface $conn, \Exception $exception)
    {
        $conn->close();
    }
/*  public function broadcastMessage($message)
    {
        $this->broadcaster->trigger('channel-name', 'event-name', ['message' => $message]);
    }*/

}
$app = new Ratchet\App('localhost', 8085);
$app->route('/maintenance', new WebSocketServer(), array('*'));
$app->route('/message', new WebSocketServer(), array('*'));
$app->route('/echo', new Ratchet\Server\EchoServer, array('*'));

echo "Starting WebSocketServer\n";
$app->run();




