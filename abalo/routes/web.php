<?php
session_start();
Route::get('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::get('/login2', [App\Http\Controllers\AuthController::class, 'login2'])->name('login2');
Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
Route::get('/isloggedin', [App\Http\Controllers\AuthController::class, 'isloggedin'])->name('haslogin');

Route::get('/articles', [App\Http\Controllers\ArticlesController::class, 'articles']);
Route::post('/articles', [App\Http\Controllers\ArticlesController::class, 'articles']);
//Route::get('/newarticle', [App\Http\Controllers\ArticlesController::class, 'newarticle']);

//Route::get('/newsite', [App\Http\Controllers\ArticlesController::class, 'newsite']);
Route::view('/newsite','newsite');
Route::view('/newarticle','newarticle');

use App\Http\Controllers\WebSocketController;

Route::get('/ws', [WebSocketController::class, 'index']);
use App\Http\Controllers\OfferController;

Route::post('/offer/{itemId}', [OfferController::class, 'offerAction'])->name('offer');

/*
 * use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use App\WebSocketServer;

Route::get('/ws', function () {
    $server = IoServer::factory(
        new HttpServer(
            new WsServer(
                new WebSocketServer()
            )
        ),
        8080 // Set the desired port for your WebSocket server
    );

    $server->run();
});
*/
