<?php

namespace App\Http\Controllers\admin_board;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\account_acount;
use App\account_authorize;
use App\account_permission;
use App\account_type;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class account_accountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $idbussiness=Auth::user()->id_business;
        $acc=new account_acount;
        return response()->json($acc->get_all_account($idbussiness)) ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function account_permission(Request $request)
    {   $idbussiness=Auth::user()->id_business;
        $arrpermission=$request->list_permission;
        account_authorize::where('id_admin',$request->id_account)->where('id_business',$idbussiness)->delete();
        foreach($arrpermission as $k=>$v)
        {
            $role=new account_authorize;
            $role->id_admin=$request->id_account;
            $role->grant_permission=$v;
            $role->id_business=Auth::user()->id_business;
            $role->save();
        }
        return response()->json([
            'success' => 200
        ],200);
    }
    public function list_manage()
    {
        $r=DB::table('tbl_account_authorize')
        ->join('tbl_account_permission','tbl_account_permission.id','=','tbl_account_authorize.grant_permission')
        ->select('tbl_account_permission.permission')
        ->where('tbl_account_authorize.id_admin',Auth::user()->id)
        ->where('tbl_account_authorize.id_business',Auth::user()->id_business)
        ->get();
        return response()->json($r);
    }
    public function get_permission(Request $request)
    {
        $r=DB::table('tbl_account_authorize')
        ->join('tbl_account_permission','tbl_account_permission.id','=','tbl_account_authorize.grant_permission')
        ->select('tbl_account_permission.permission','tbl_account_permission.id','tbl_account_permission.description')
        ->where('tbl_account_authorize.id_admin',$request->id_account)
        ->where('tbl_account_authorize.id_business',Auth::user()->id_business)
        ->get();
        $listper=account_permission::where('id_business',Auth::user()->id_business)->get();
        return response()->json([
            'account_per' => $r,
            'list_per'=> $listper
        ],200);
    }
    public function account_detail(Request $request)
    {
        $idbussiness=Auth::user()->id_business;
        $account=new account_acount;
        $detai=account_acount::where('id',$request->id_account)->where('id_business',$idbussiness)->get();
        $per=$account->get_permission($request->id_account);
        return response()->json([
            'success' => 200,
            'data' =>["detail"=>$detai,"permission"=>$per]
        ],200);
    }
    public function account_disable(Request $request)
    {
        account_acount::where('id',$request->id_account)->update(['account_status'=>$request->account_status]);
        $acc=account_acount::where('id',$request->id_account)->get();
        return response()->json([
            'success' => 200,
            'data'=>$acc
        ],200);
    }
    public function account_change_password(Request $request)
    {

       account_acount::where('id',$request->id_account)->update(['account_password'=>md5($request->account_password)]);
            $acc=account_acount::where('id',$request->id_account)->get();
            return response()->json([
                'success' => 200,
                'message'=>'Cập nhật mật khẩu thành công',
            ]);


    }
    public function account_change_password_dashboard(Request $request)
    {
        $old_pass=md5($request->old_password);
        $check=DB::table('tbl_account_account')
        ->where('id',Auth::user()->id)
        ->where('account_password',$old_pass)->get();
        if(count($check)>0)
        {
            account_acount::where('id',Auth::user()->id)->update(['account_password'=>md5($request->account_password)]);
            $acc=account_acount::where('id',$request->id_account)->get();
            return response()->json([
                'success' => 200,
                'message'=>"Cập nhật mật khẩu thành công"
            ]);

        }
        else
        {
            return response()->json([
                'success' => 300,
                'message'=>'Mật khẩu cũ không đúng',
            ]);
        }

    }
    public function store(Request $request)
    {
        $checkphone=account_acount::where('account_phone',$request->account_phone)->get();
        $checkemail=account_acount::where('account_email',$request->account_email)->get();
        $checkusername=account_acount::where('account_username',$request->account_username)->get();
        if(count($checkemail)>0 && $request->account_email!="")
        {
            return response()->json([
                'success' => 300,
                'message'=>"Email đã được sử dụng",
            ],200);
        }
        if(count($checkusername)>0)
        {
            return response()->json([
                'success' => 300,
                'message'=>"Username đã được sử dụng",
            ],200);
        }
        if(count($checkphone)>0 && $request->account_phone!="")
        {
            return response()->json([
                'success' => 300,
                'message'=>"Số điện thoại đã được sử dụng",
            ],200);
        }
            $acc=new account_acount;
            $acc->id_type=$request->id_type;
            $acc->id_business=$request->id_business;
            $acc->account_username=$request->account_username;
            $acc->account_password=md5($request->account_password);
            $acc->account_fullname=$request->account_fullname;
            $acc->account_email=$request->account_email;
            $acc->account_phone=$request->account_phone;
            $acc->account_status='Y';
            $acc->save();
            return response()->json([
                'success' => 200,
                'message'=>"Thêm thành công",
                'data'=>$acc
            ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   $idbussiness=Auth::user()->id_business;
        $acc=account_acount::where('id',$id)->where('id_business',$idbussiness)->get();
        $type=account_type::all();
        return response()->json([
            'success' => 200,
            'data'=>$acc,
            'type'=>$type
        ],200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $checkphone=account_acount::where('account_phone',$request->account_phone)
        ->whereNotIn('id',[$id])
        ->get();
        $checkemail=account_acount::where('account_email',$request->account_email)
        ->whereNotIn('id',[$id])
        ->get();
        $checkusername=account_acount::where('account_username',$request->account_username)
        ->whereNotIn('id',[$id])
        ->get();
        if(count($checkemail)>0 && $request->account_email!="")
        {
            return response()->json([
                'success' => 300,
                'message'=>"Email đã được sử dụng",
            ],200);
        }
        if(count($checkusername)>0)
        {
            return response()->json([
                'success' => 300,
                'message'=>"Username đã được sử dụng",
            ],200);
        }
        if(count($checkphone)>0 && $request->account_phone!="")
        {
            return response()->json([
                'success' => 300,
                'message'=>"Số điện thoại đã được sử dụng",
            ],200);
        }
        else
        {
            $acc=account_acount::where('id',$id)->update([
                'account_username'=>$request->account_username,
                'account_fullname'=>$request->account_fullname,
                'account_email'=>$request->account_email,
                'account_phone'=>$request->account_phone,
                'id_type'=>$request->id_type,
            ]);
            return response()->json([
                'success' => 200,
                'message'=>"Cập nhật thành công",
            ],200);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
