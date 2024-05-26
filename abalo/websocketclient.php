<?php
/**
 * /websocketclient.php (im Laravel-Wurzelverzeichnis)
 * composer.json +Abhängigkeit: ratchet/pawl
 * Quelle des Beispiels: https://github.com/ratchetphp/Pawl (Letzter Zugriff 8.3.2022)
 */
require __DIR__ . '/vendor/autoload.php';

\Ratchet\Client\connect('ws://localhost:8085/maintenance')
    ->then(function($conn) {
        $conn->on('message', function($msg) use ($conn) {
            echo "Received: {$msg}\n";
            $conn->close();

        });
        $conn->send("In Kürze verbessern wir Abalo für Sie!\nNach einer kurzen Pause sind wir wieder für Sie da!\nVersprochen.");
        $conn->close();
}, function ($e) {
    echo "Could not connect: {$e->getMessage()}\n";
});
