<?php

namespace App\Http\Controllers;

use App\Models\shoppingcart;
use App\Models\users;
use Illuminate\Http\Request;

/**
 * Write static login information to the session.
 * Use for test purposes.
 */
class AuthController extends Controller
{
    public function login(Request $request) {
        $request->session()->put('abalo_user', 'visitor');
        $request->session()->put('abalo_mail', 'visitor@abalo.example.com');
        $request->session()->put('abalo_time', time());
        $request->session()->put('abalo_id',users::getUserId($request->session()->get("abalo_mail")));
        $_SESSION['ab_creator_id']=users::getUserId($request->session()->get("abalo_mail"));
        $_SESSION['abalo_shoppingcartid']=shoppingcart::createShoppingcart($request->session()->get('abalo_id'));
        return redirect()->route('haslogin');
    }

    public function login2(Request $request) {
        $request->session()->put('abalo_user', 'visitor2');
        $request->session()->put('abalo_mail', 'visitor2@abalo.example.com');
        $request->session()->put('abalo_time', time());
        $request->session()->put('abalo_id',users::getUserId($request->session()->get("abalo_mail")));
        $_SESSION['ab_creator_id']=users::getUserId($request->session()->get("abalo_mail"));
        $_SESSION['abalo_shoppingcartid']=shoppingcart::createShoppingcart($request->session()->get('abalo_id'));
        return redirect()->route('haslogin');
    }

    public function logout(Request $request) {
        $request->session()->flush();
        return redirect()->route('haslogin');
    }


    public function isLoggedIn(Request $request) {
        if($request->session()->has('abalo_user')) {
            $r["user"] = $request->session()->get('abalo_user');
            $r["time"] = $request->session()->get('abalo_time');
            $r["mail"] = $request->session()->get('abalo_mail');
            $r["id"] = $request->session()->get('abalo_id');
            $r["shoppingcart"] = $request->session()->get('abalo_shoppingcartid');
            $r["auth"] = "true";
        }
        else $r["auth"]="false";
        return response()->json($r);
    }
}
