<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class shoppingcart extends Model
{
    use HasFactory;

    public static function getShoppingcartId(){
        $id= session()->get('abalo_id');
        return $id;
    }

    public static function addToShoppingcart($aid,$sid){
        if($aid!=null&&$sid!=null) {
            if(!shoppingcart::inShoppingcart($aid,$sid)){
                if(!articles::isIdArticle($aid)){
                    return false;
                }

                DB::table('ab_shoppingcart_item')->insert([
                    'ab_shoppingcart_id' => $sid,
                    'ab_article_id' => $aid,
                    'ab_createdate'=>date("Y.m.d H:i")
                ]);
            }else{
                return false;
            }
        }else{
            return false;
        }
        return true;
    }

    public static function inShoppingcart($aid,$sid){
        $shoppingcart= DB::query()->from("ab_shoppingcart_item")
            ->where("ab_shoppingcart_id",$sid)
            ->where("ab_article_id",$aid)
            ->get()->toArray();
        if($shoppingcart != null){
            return true;
        }
        return false;
    }

    public static function hasShoppingcart($id){
        $shoppingcart= DB::query()->from("ab_shoppingcart")->where("ab_creator_id",session()->get("abalo_id"))->get()->toArray();
        if($shoppingcart != null){
            return $shoppingcart[0]->id;
        }
        return false;
    }

    public static function createShoppingcart($id){
        if(!self::hasShoppingcart($id)){
            try {
                DB::table('ab_shoppingcart')->insert([
                    'ab_creator_id' => $id,
                    'ab_createdate'=>date("Y.m.d H:i")
                ]);
            } catch (QueryException $ex) {
                return false;
            }
        }
        return self::hasShoppingcart($id);
    }

    public static function deleteFromShoppingcart($sid,$aid){
        if($sid!=null&&$aid!=null) {
            if(!articles::isIdArticle($aid)){
                return false;
            }
            try {
                DB::table('ab_shoppingcart_item')->where("ab_shoppingcart_id",'=',$sid)->where("ab_article_id",'=',$aid)->delete();
            } catch (QueryException $ex) {
                return false;
            }
        }else{
            return false;
        }
        return true;
    }

    public static function getShoppingcartItems($id){
        $items= DB::query()->from("ab_shoppingcart_item")->where("ab_shoppingcart_id","=",$id)->get()->toArray();
        return $items;
    }

    public static function getShoppingcartArticles($id){
        $items= DB::query()->select(
            'a.id',
            'a.ab_name'
        )
        ->from("ab_shoppingcart_item as s")->join("ab_article as a","s.ab_article_id","=","a.id")->where("s.ab_shoppingcart_id","=",$id)->get()->toArray();
        return $items;
    }


    public static function getShoppingcartItemIds($id){
        $items=self::getShoppingcartItems($id);

    }
}
