<?php

namespace App\Http\Controllers;

use App\Models\articles;
use App\Models\shoppingcart;
use Illuminate\Http\Request;

class ShoppingcartController extends Controller
{
    public function addToShoppingcart_api(Request $request){
        if(isset($_POST['articleid'])){
            shoppingcart::addToShoppingcart($_POST['articleid'],$_SESSION['abalo_shoppingcartid']);
        }
    }

    public function deleteFromShoppingcart_api($shoppingcartid, $articleid){
            shoppingcart::deleteFromShoppingcart($shoppingcartid,$articleid);
    }

    public function getShoppingcart_api(){
        $articles = shoppingcart::getShoppingcartArticles($_SESSION['abalo_shoppingcartid']);
        foreach ($articles as $article) {
            if (file_exists("articelimages/" . $article->id . ".jpg")) {
                $article->picture = url("articelimages/" . $article->id . ".jpg");
            } elseif (file_exists("articelimages/" . $article->id . ".png")) {
                $article->picture = url("articelimages/" . $article->id . ".png");
            } else {
                $article->picture = url("articelimages/" . "null.png");
            }
        }
        return response()->json(['shoppingcart' => $articles]);
    }
}
