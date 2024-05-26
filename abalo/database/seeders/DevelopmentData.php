<?php

namespace Database\Seeders;

use Faker\Core\DateTime;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use MongoDB\BSON\Timestamp;

class DevelopmentData extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $user= fopen(base_path("database/data/user.csv"),"r");

       $firstline = true;
       while (($data = fgetcsv($user, 2000, ";")) !== FALSE) {
            if (!$firstline) {
                DB::table('ab_user')->insert([
                    'id' => (int)$data[0],
                    'ab_name' => (string)$data[1],
                    'ab_password' => (string)$data[2],
                    'ab_mail' => (string)$data[3]
                ]);
            }
            $firstline=false;
        }
        fclose($user);

        $firstline = true;

        $article= fopen(base_path("database/data/articles.csv"),"r");
        while (($data = fgetcsv($article, 2000, ";")) !== FALSE) {
           if (!$firstline) {
               DB::table('ab_article')->insert([
                   'id' => (int)$data[0],
                   'ab_name' => (string)$data[1],
                   'ab_price' => (int)str_replace('.','',$data[2]),
                   'ab_description' => (string)$data[3],
                   'ab_creator_id' => (int)$data[4],
                   "ab_createdate" => date("Y.m.d H:i",\DateTime::createFromFormat("j.n.y H:i", $data[5])->getTimestamp())
               ]);
           }
           $firstline=false;
        }
        fclose($article);

        $articlecategory=fopen(base_path("database/data/articlecategory.csv"),"r");

        $firstline = true;
        while (($data = fgetcsv($articlecategory, 2000, ";")) !== FALSE) {
            if(strcmp((string)$data[2],"NULL")==0) {
                $parent=null;
            }else{
                $parent=(int)$data[2];
            }
            if (!$firstline) {
                DB::table('ab_articlecategory')->insert([
                    'id' => (int)$data[0],
                    'ab_name' => (string)$data[1],
                    'ab_parent'=>$parent
                ]);
            }
            $firstline = false;
        }
        fclose($articlecategory);

        $articlecategory=fopen(base_path("database/data/article_has_articlecategory.csv"),"r");

        $firstline = true;
        $num=0;
        while (($data = fgetcsv($articlecategory, 2000, ";")) !== FALSE) {
            if (!$firstline) {
                DB::table('ab_article_has_articlecategory')->insert([
                    'id' => $num,
                    'ab_articlecategory_id' => (int)$data[0],
                    'ab_article_id'=> (int)$data[1],
                ]);
            }
            $firstline = false;
            $num++;
        }
        fclose($articlecategory);
    }


}


