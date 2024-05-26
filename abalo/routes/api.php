<?php

use App\Http\Controllers\ArticlesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/articles', [ArticlesController::class, 'addArticle_api']);
Route::post('/shoppingcart', [App\Http\Controllers\ShoppingcartController::class, 'addToShoppingcart_api']);
Route::delete('/shoppingcart/{shoppingcartid}/articles/{articleId}', [App\Http\Controllers\ShoppingcartController::class, 'deleteFromShoppingcart_api']);
Route::post('/angebot',[\App\Http\Controllers\AngebotController::class,'offerAction']);
Route::get('/angebot', [\App\Http\Controllers\AngebotController::class,'getAngebot']);

Route::get('/articles', [ArticlesController::class,'articles_api']);
Route::get('/newsite', [ArticlesController::class,'articles_api']);
Route::get('/shoppingcart', [App\Http\Controllers\ShoppingcartController::class, 'getShoppingcart_api']);
Route::post('/articles/{id}/sold',[ArticlesController::class,'soldArticle_api']);
