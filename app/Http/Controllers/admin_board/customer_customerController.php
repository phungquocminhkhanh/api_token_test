<?php

namespace App\Http\Controllers\admin_board;

use App\customer_customer;
use App\customer_point;
use App\Http\Controllers\Controller;
use App\order_order;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class customer_customerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    public function get_customer(Request $request)
    {
        $sql='select * from tbl_customer_customer where 1=1 and id_business='.Auth::user()->id_business;
        if($request->id_customer)
        {

                $sql.=' and id='.$request->id_customer;

        }
        $cus=DB::select($sql);
        return response()->json($cus);
    }
    public function customer_seach(Request $request)
    {
        $id=Auth::user()->id_business;
        $sql="";
        if($request->key_seach)
        {
            $sql="select * from tbl_customer_customer where id_business=$id
             and (customer_phone like '%$request->key_seach%'
             or customer_name like '%$request->key_seach%'
              or customer_email like '%$request->key_seach%'
              or customer_code like '%$request->key_seach%')";
            $cus =DB::select($sql);
                return response()->json([
                    'status'=>200,
                    'data'=>$cus
                ]);

        }
        else
        {
                $cus=DB::table('tbl_customer_customer')->where('id_business',Auth::user()->id_business)->get();
                return response()->json([
                    'status'=>200,
                    'data'=>$cus
                ]);
        }


    }
    public function customer_order(Request $request)
    {
        $arr=array();
        $detail_cus=array();
        $point=customer_point::where('id_business',Auth::user()->id_business)->get();
        foreach($point as $k=>$v)
        {
            $arr[]=["point"=>(int)$v->customer_point,
            "customer_level"=>$v->customer_level,
        ];
        }
        sort($arr);
        $cus=customer_customer::where('id_business',Auth::user()->id_business)->where('id',$request->id_customer)->get();
       $detail_cus=[
            'customer_level'=>'',
            'customer_name'=>$cus[0]->customer_name,
            'customer_sex'=>$cus[0]->customer_sex,
            'customer_email'=>$cus[0]->customer_email,
            'customer_taxcode'=>$cus[0]->customer_taxcode,
            'customer_address'=>$cus[0]->customer_address,
            'customer_code'=>$cus[0]->customer_code,
            'customer_created_by'=>$cus[0]->customer_created_by,
       ];
        foreach($arr as $j=>$p)
        {
            if($cus[0]->customer_point>$p['point'])
            {
                $detail_cus['customer_level']=$p['customer_level'];
            }
        }

        $order=DB::table('tbl_order_order')
        ->join('tbl_customer_customer','tbl_customer_customer.id','=','tbl_order_order.id_customer')
        ->join('tbl_order_detail','tbl_order_detail.id_order','=','tbl_order_order.id')
        ->select('tbl_order_order.id',
        'tbl_order_order.order_status',
        'tbl_order_order.order_created',
        'tbl_order_order.order_code',
        'tbl_customer_customer.customer_phone',
        'tbl_customer_customer.customer_address',
        'tbl_customer_customer.customer_name',
        DB::raw('sum(tbl_order_detail.detail_cost) as total_cost'))
        ->groupBy('tbl_order_order.id',
        'tbl_order_order.order_status',
        'tbl_order_order.order_created',
        'tbl_order_order.order_code',
        'tbl_customer_customer.customer_phone',
        'tbl_customer_customer.customer_address',
        'tbl_customer_customer.customer_name')
        ->where('tbl_order_order.id_customer',$request->id_customer)
        ->get();
        return response()->json([
            'order'=>$order,
            'detail'=>$detail_cus
        ]);
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
    public function store(Request $request)
    {

        $check=customer_customer::where('customer_phone',$request->customer_phone)
        ->where('id_business',Auth::user()->id_business)->get();
        if(count($check)>0 && $request->customer_phone!="")
        {
            return response()->json([
            'status' => 300,
            'message'=>"Số điện thoại này đã được sử dụng",
        ],200);
        }

        $checkmail=customer_customer::where('customer_email',$request->customer_email)
        ->where('id_business',Auth::user()->id_business)
        ->get();
        if(count($checkmail)>0 && $request->customer_email!="")
        {
            return response()->json([
                'status' => 300,
                'message'=>"Email này đã được sử dụng",
            ]);
        }
        $checkcode=customer_customer::where('customer_code',$request->customer_code)->get();
        if(count($checkcode)>0)
        {
            return response()->json([
                'status' => 300,
                'message'=>"Mã khách hàng này đã được sử dụng",
            ]);
        }
        $characters = '0123456789';
        $randomString = '';
        for ($i = 0; $i < 8; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        $business=DB::table('tbl_business_store')->where('id',Auth::user()->id_business)->get();
        $code=$business[0]->store_prefix.'KH'.$randomString;



        $cus=new customer_customer();
        $cus->id_business=Auth::user()->id_business;
        $cus->id_account=Auth::user()->id;
        $cus->customer_code=$code;
        $cus->customer_name=$request->customer_name;
        $cus->customer_phone=$request->customer_phone;
        $cus->customer_sex=$request->customer_sex;
        $cus->customer_email=$request->customer_email;
        $cus->customer_birthday=$request->customer_birthday;
        $cus->customer_address=$request->customer_address;
        $cus->customer_point=0;
        $cus->customer_taxcode=$request->customer_taxcode;

        $cus->save();
        return response()->json([
            'status' => 200,
            'message'=>"Thêm thành công",
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

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

        $checkpass=customer_customer::where('customer_phone',$request->customer_phone)
        ->whereNotIn('id',[$id])->get();
        $checkemail=customer_customer::where('customer_email',$request->customer_email)
        ->whereNotIn('id',[$id])->get();
        $checkcode=customer_customer::where('customer_code',$request->customer_code)
        ->whereNotIn('id',[$id])->get();
        if(count($checkpass)>0 && $request->customer_phone!="")
        {
            return response()->json([
                'status' => 300,
                'message'=>"Số điện thoại này đã được sử dụng",
            ],200);
        }
        if(count($checkemail)>0 && $request->customer_email!="")
        {

            return response()->json([
                'status' => 300,
                'message'=>"Email này đã được sử dụng",
            ],200);
        }
        if(count($checkcode)>0)
        {
            return response()->json([
                'status' => 300,
                'message'=>"Mã khách hàng này đã được sử dụng",
            ],200);
        }

            customer_customer::where('id',$id)->update([
                "customer_name"=>$request->customer_name,
                "customer_phone"=>$request->customer_phone,
                "customer_address"=>$request->customer_address,
                "customer_email"=>$request->customer_email,
                "customer_birthday"=>$request->customer_birthday,
                "customer_sex"=>$request->customer_sex,
                "customer_address"=>$request->customer_address,
                "customer_taxcode"=>$request->customer_taxcode,
            ]);
           return response()->json([
               'status' => 200,
               'message'=>"Cập nhật thành công",
           ],200);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try
        {
            $check=order_order::where('id_customer',$id)->where('id_business',Auth::user()->id_business)->get();
            if(count($check)>0)
            {
                return response()->json([
                    'status' => 200,
                    'message'=>"Không thể xóa khách hàng đã có đơn hàng",
                ]);
            }
            customer_customer::where('id',$id)->where('id_business',Auth::user()->id_business)->delete();
            return response()->json([
                'status' => 200,
                'message'=>"Xóa thành công",
            ]);
        }
        catch(Exception $e)
        {

            return response()->json([
                'status' => 200,
                'message'=>"Xóa thất bại",
            ]);

        }
    }
}
