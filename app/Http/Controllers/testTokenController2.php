<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class testTokenController2 extends Controller
{
    public function getdata_sudung_token()
    {
        $a=Auth::user();
        if($a)
        {
            return response()->json([
                'ok' => 'get dc data',
                'user'=>$a
            ]);
        }
        else
        {
            return response()->json([
                'fail' => 'token sai hoac het han'   //token sai hoac het han
            ]);
        }
    }
}
