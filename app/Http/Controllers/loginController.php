<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\account_acount;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
session_start();

class loginController extends Controller
{
    public function login(Request $request)
    {

        if(Auth::attempt(['account_username' => $request->account_username, 'account_password' => $request->account_password]))
        {
            $check=Auth::user()->get_type();
            if($check[0]->type_account=='admin' && $check[0]->account_status=='Y')
            {
                $a=account_acount::where('id_business',Auth::user()->id_business)
                ->where('id',Auth::user()->id)
                ->update(["force_sign_out"=>"0"]);

                Session::put("mess","");

                return Redirect("/dashboard");
            }
            else
            {

                return Redirect("/");

            }

        }
        else
        {
            Session::put("mess","Username hoặc password không đúng");
            return Redirect("/");
        }

    }
    public function logout()
    {   $a=account_acount::where('id_business',Auth::user()->id_business)
        ->where('id',Auth::user()->id)
        ->update(["force_sign_out"=>"1"]);
        Auth::logout();
        return Redirect("/");

    }
    public function send_otp(Request $request)
    {

        //$arrEmail = ['khanh01636819000@gmail.com'];
        try
        {
            $data = ['mail'=>'khanh01636819000@gmail.com','otp' => '45465'];
            Mail::send(function($message){
                 $message->from('khanh.phungquocminh@gmail.com', 'QTC infomatic')->subject('Visitor Feedback!');
                 $message->to('khanh01636819000@gmail.com')->subject('MÃ XÁC NHẬN OTP');
           });
           return response()->json([
               'status'=>200
           ]);
        }
        catch(Exception $e)
        {
            return response()->json([
                'err'=>$e
            ]);
        }

    }



}
