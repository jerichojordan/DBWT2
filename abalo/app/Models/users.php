<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class users extends Model
{
    use HasFactory;

    public static function getUserId($email){
        $user= DB::query()->from("ab_user")->where("ab_mail",$email)->get()->toArray();
        return $user[0]->id;
    }
}
