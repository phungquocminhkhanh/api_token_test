<?php

namespace App\Http\Controllers\admin_board;

use App\customer_customer;
use App\customer_point;
use App\Http\Controllers\Controller;
use FFI\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class customer_pointController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   $arr=array();
        $point=customer_point::where('id_business',Auth::user()->id_business)->get();
        foreach($point as $k=>$v)
        {
            $arr[]=["point"=>(int)$v->customer_point,
            "id"=>$v->id,
            "customer_level"=>$v->customer_level,
            "total_customer"=>0,
            "customer_discount"=>$v->customer_discount,
            "customer_description"=>$v->customer_description
        ];
        }
        sort($arr);
        $cus=customer_customer::where('id_business',Auth::user()->id_business)->get();
        foreach($cus as $k=>$v)
        {
            $i=0;
            foreach($arr as $j=>$p)
            {
                if($v->customer_point>$p['point'])
                    $i=$i+1;

            }
            if($i!=0)
            {
                $arr[$i-1]['total_customer']+=1;
            }
        }

        return response()->json($arr);
    }
    public function point_customer(Request $request)
    {
        $arr=array();// mảng tạm, lưu giá trị point tăng dần thì ms làm dc
        $point=customer_point::where('id_business',Auth::user()->id_business)->get();
        $cus=customer_customer::where('id_business',Auth::user()->id_business)->get();
        foreach($point as $k=>$v)
        {
            $arr[]=["point"=>(int)$v->customer_point,
            "id"=>$v->id,
            "total_customer"=>0,
        ];
        }
        sort($arr);
        $arraytam=[];

        foreach($cus as $k=>$v)
        {

            $i=0;

            $dem=0;
            foreach($arr as $j=>$p)
            {
                if($v->customer_point>$p['point'])
                    $i=$i+1;

            }
            if($i!=0)
                {
                    $arr[$i-1]['total_customer']+=1;
                    $arraytam[$i-1][]=$v;
                }

        }
        $tam=0;
        $point2=customer_point::where('id_business',Auth::user()->id_business)->where('id',$request->id_point)->get();
        foreach($arr as $k=>$v)
        {
           if($v['id']==$point2[0]->id)
           {
               $tam=$k;
           }
        }
        if(isset($arraytam[$tam]))
        {
            $point2[0]['list_customer']=$arraytam[$tam];
            return response()->json($point2);
        }

        else
        {
            $point2[0]['list_customer']=[];
            return response()->json($point2);
        }
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
        try
        {
            $check=customer_point::where('id_business',Auth::user()->id_business)
            ->where('customer_level',$request->customer_level)->get();
            if(count($check)>0)
            {
                return response()->json([
                    'status' => 300,
                    'message'=>"Tên cấp độ đã tồn tại",
                ],200);
            }
            else
            {
                $cus=new customer_point();
                $cus->id_business=Auth::user()->id_business;
                $cus->customer_level=$request->customer_level;
                $cus->customer_point=$request->customer_point;
                $cus->customer_discount=$request->customer_discount;
                $cus->customer_description=$request->customer_description;
                $cus->save();
                return response()->json([
                    'status' => 200,
                    'message'=>"Thêm thành công",
                ],200);
            }

        }catch(Exception $e)
        {
            return response()->json([
            'status' => 500 ,
            'message'=>"Thêm thất bại",
             ],200);


        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json(customer_point::where('id_business',Auth::user()->id_business)->where('id',$id)->get());
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
        try
        {
            $check=customer_point::where('id_business',Auth::user()->id_business)
            ->where('customer_level',$request->customer_level)
            ->whereNotIn('id',[$id])->get();
            if(count($check)>0)
            {
                return response()->json([
                    'status' => 300,
                    'message'=>"Tên cấp độ đã tồn tại",
                ],200);
            }
            customer_point::where('id',$id)
            ->where('id_business',Auth::user()->id_business)
            ->update([
                'customer_level'=>$request->customer_level,
                'customer_point'=>$request->customer_point,
                'customer_discount'=>$request->customer_discount,
                'customer_description'=>$request->customer_description
            ]);

            return response()->json([
                'status' => 200,
                'message'=>"Cập nhật thành công",
            ],200);
        }catch(Exception $e)
        {

            return response()->json([
                'status' => 200,
                'message'=>"Cập nhật thất bại",
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
        try
        {
            customer_point::where('id',$id)->where('id_business',Auth::user()->id_business)->delete();
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
