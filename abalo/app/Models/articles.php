<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use function GuzzleHttp\describe_type;

class articles extends Model
{
    use HasFactory, HasApiTokens;

    public static function findArticle($aid){
        $article= DB::query()->from("ab_article")->where("id","=",$aid)->get()->toArray();
        return $article[0];
    }

    public static function getArticles($like){
        $articles= DB::query()->from("ab_article")->where("ab_name","ilike","%".$like."%")->get()->toArray();
        return $articles;
    }

    public static function getArticlesPage($like,$page){
        $limit=5;
        $offset=$page*$limit;
        $articles= DB::query()->from("ab_article")->where("ab_name","ilike","%".$like."%")->limit($limit)->offset($offset)->get()->toArray();
        if($articles==null){
            return false;
        }
        return $articles;
    }

    public static function getLatestArticle(){
        $articles= DB::query()->from("ab_article")->orderByDesc('id')->limit(1)->get()->toArray();
        return $articles;
    }

    public static function insertArticle($name,$price,$description){
        if($name!=null&&$name!=''&&$price>0) {
            if($description==null){
                $description='';
            }
            try {
                DB::table('ab_article')->insert([
                    'id'=>self::getLatestArticle()[0]->id+1,
                    'ab_name' => $name,
                    'ab_price' => $price,
                    'ab_description' => $description,
                    'ab_creator_id'=> 2,
                    'ab_createdate'=>date("Y.m.d H:i")
                ]);
            } catch (QueryException $ex) {
                return false;
            }
        }else{
            return false;
        }
        return true;
    }

    public static function isIdArticle($id){
        $articles= DB::query()->from("ab_article")->where("id",$id)->get()->toArray();
        return $articles;
    }
}
