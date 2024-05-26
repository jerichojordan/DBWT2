<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\articles;

class ArticlesController extends Controller
{
    public function articles(Request $request){
        $insertError=false;
        if(isset($_POST['name'])&&isset($_POST['price'])){
            if(!articles::insertArticle($_POST['name'],$_POST['price'],$_POST['description'])){
                $insertError=true;
            }
        }
        if(isset($_GET['search'])){
            return view('articles',['articles'=>articles::getArticles($_GET['search']),'insertError'=>$insertError]);
        }
        else{
            return view('articles',['articles'=>articles::getArticles(''),'insertError'=>$insertError]);
        }
    }
    public function newsite(Request $request){
        $insertError=false;
        if(isset($_POST['name'])&&isset($_POST['price'])){
            if(!articles::insertArticle($_POST['name'],$_POST['price'],$_POST['description'])){
                $insertError=true;
            }
        }
        if(isset($_GET['search'])){
            return view('newsite',['articles'=>articles::getArticles($_GET['search']),'insertError'=>$insertError]);
        }
        else{
            return view('newsite',['articles'=>articles::getArticles(''),'insertError'=>$insertError]);
        }
    }

    public function articles_api(Request $request)
    {
        $insertError = false;
        if (isset($_POST['name']) && isset($_POST['price'])) {
            if (!articles::insertArticle($_POST['name'], $_POST['price'], $_POST['description'])) {
                $insertError = true;
            }
        }
        if (isset($_GET['page'])) {
            if (isset($_GET['search'])) {
                if((int) $_GET['page']<0){
                    return null;
                }
                $articles=articles::getArticlesPage($_GET['search'],(int)$_GET['page']);
                if($articles!=false){
                   foreach ($articles as $article) {
                       if (file_exists("articelimages/" . $article->id . ".jpg")) {
                           $article->picture = url("articelimages/" . $article->id . ".jpg");
                       } elseif (file_exists("articelimages/" . $article->id . ".png")) {
                           $article->picture = url("articelimages/" . $article->id . ".png");
                       } else {
                           $article->picture = url("articelimages/" . "null.png");
                       }
                   }
                    return response()->json(['article' => $articles]);
                }else{
                    return null;
                }
            }
        }else{
            if (isset($_GET['search'])) {
                $articles = articles::getArticles($_GET['search']);
                foreach ($articles as $article) {
                    if (file_exists("articelimages/" . $article->id . ".jpg")) {
                        $article->picture = url("articelimages/" . $article->id . ".jpg");
                    } elseif (file_exists("articelimages/" . $article->id . ".png")) {
                        $article->picture = url("articelimages/" . $article->id . ".png");
                    } else {
                        $article->picture = url("articelimages/" . "null.png");
                    }
                }
                return response()->json(['article' => $articles]);
            }
        }
    }

    public function newArticle(Request $request){
        return view('newArticle');
    }

    public function addArticle_api(Request $request){
        if(isset($_POST['name'])&&isset($_POST['price'])&&(trim($_POST['name'])!='')&&($_POST['price']>0)) {
            if (articles::insertArticle($_POST['name'], $_POST['price'], $_POST['description'])) {
                return response()->json(array("id" => articles::getLatestArticle()[0]->id));
            }
        }
    }

    public function soldArticle_api($id){
        $article= articles::findArticle($id);
        if(isset($id) && $article->ab_creator_id == 2){
            $articlename= $article->ab_name;
            \Ratchet\Client\connect('ws://localhost:8085/message')->then(function ($conn) use ($articlename){
                $conn->on('message',function($msg) use ($conn){
                    echo "Received: {$msg}\n";
                    $conn->close();
                });
                $conn->send("Großartig! Ihr Artikel: $articlename wurde erfolgreich verkauft!");
                $conn->close();
            }, function ($error){
                echo "Could not connect>: {$error->getMessage()}\n";
            });
        }
    }
}
