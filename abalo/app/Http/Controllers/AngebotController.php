<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AngebotController extends Controller
{
    public function offerAction(Request $request)
    {
        $articleoffer = $request->input('offer');
        session()->put('articleoffer',$articleoffer);
        $testoffer = session('articleoffer');
        return response()->json(['articleoffer' => $testoffer]);
    }
    public function getAngebot(Request $request) {
        $getoffer = session('articleoffer',[]);
        return response()->json(['getoffer' => $getoffer]);
    }
}
