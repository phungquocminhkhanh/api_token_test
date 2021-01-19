<?php

namespace App\Http\Controllers\admin_board;

use App\account_acount;
use App\account_permission;
use App\customer_customer;
use App\Http\Controllers\Controller;
use App\order_order;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class order_orderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $or=DB::table('tbl_order_order')
        ->leftJoin('tbl_organization_floor','tbl_organization_floor.floor_title','=','tbl_order_order.order_floor')
        ->leftJoin('tbl_order_detail','tbl_order_detail.id_order','=','tbl_order_order.id')
        ->select('tbl_order_order.id',
        'tbl_order_order.order_created',
        'tbl_order_order.order_direct_discount',
        'tbl_order_order.order_total_cost',
        'tbl_order_order.order_status',
        'tbl_order_order.order_code',
        'tbl_organization_floor.floor_type',DB::raw('count(tbl_order_detail.id_order) as total_product'))
        ->groupBy('tbl_order_order.id',
        'tbl_order_order.order_created',
        'tbl_order_order.order_direct_discount',
        'tbl_order_order.order_total_cost',
        'tbl_order_order.order_status',
        'tbl_order_order.order_code',
        'tbl_organization_floor.floor_type')
        ->where('tbl_order_order.id_business',Auth::user()->id_business)
        ->get();
        return response()->json($or);
    }
    public function get_order_order(Request $request)
    {
        $or=DB::table('tbl_order_order')
        ->leftJoin('tbl_organization_floor','tbl_organization_floor.floor_title','=','tbl_order_order.order_floor')
        ->leftJoin('tbl_order_detail','tbl_order_detail.id_order','=','tbl_order_order.id')
        ->select('tbl_order_order.id',
        'tbl_order_order.order_created',
        'tbl_order_order.order_direct_discount',
        'tbl_order_order.order_total_cost',
        'tbl_order_order.order_status',
        'tbl_order_order.order_code',
        'tbl_organization_floor.floor_type',DB::raw('count(tbl_order_detail.id_order) as total_product'))
        ->groupBy('tbl_order_order.id',
        'tbl_order_order.order_created',
        'tbl_order_order.order_direct_discount',
        'tbl_order_order.order_total_cost',
        'tbl_order_order.order_status',
        'tbl_order_order.order_code',
        'tbl_organization_floor.floor_type')
        ->where('tbl_order_order.id_business',Auth::user()->id_business)
        ->get();
        return response()->json($or);
    }
    public function order_order_detail(Request $request)
    {
        $order=DB::table('tbl_order_order')->where('id',$request->id_order)->get();
        $code_cus="khách vãng lai";
        if($order[0]->id_customer!=0)
        {
            $customer=customer_customer::where('id',$order[0]->id_customer)->get();
            $code_cus=$customer[0]->customer_code;
        }

        $acc=account_acount::where('id',$order[0]->id_account)->get();
        $account=account_acount::where('id',$order[0]->id_account)->get();
        $d=array();
        $array_order=array();


        $array_order=array([
            "id"=>$order[0]->id,
            "account_username"=>$acc[0]->account_username,
            "id_customer"=>$code_cus,
            "order_status"=>$order[0]->order_status,
            "order_code"=>$order[0]->order_code,
            "order_comment"=>$order[0]->order_comment,
            "order_direct_discount"=>$order[0]->order_direct_discount,
            "order_total_cost"=>$order[0]->order_total_cost,
            "order_created"=>$order[0]->order_created,
            "floor_title"=>$order[0]->order_floor,
            "table_title"=>$order[0]->order_table,
            "detail"=>$d
        ]);
        $detail=DB::table('tbl_order_detail')
        ->leftJoin('tbl_product_product','tbl_product_product.id','=','tbl_order_detail.id_product')
        ->select('tbl_order_detail.id',
        'tbl_order_detail.id_product',
        'tbl_product_product.product_title',
        'tbl_product_product.product_sales_price',
        'tbl_order_detail.detail_extra',
        'tbl_order_detail.detail_quantity',
        'tbl_order_detail.detail_cost',
        'tbl_order_detail.detail_status')
        ->where('id_order',$order[0]->id)->get();
        $array_detail=array();
        foreach($detail as $k=>$v)
        {
            $extra=explode(",",$v->detail_extra);
            $product=array();
            foreach($extra as $j=>$e)
            {
                $product[]=DB::table('tbl_product_product')
                ->where('id',$e)
                ->select('product_title','product_sales_price')
                ->get();
            }
            $array_detail[]=[
                "id"=>$v->id,
                "id_product"=>$v->id_product,
                "product_title"=>$v->product_title,
                "product_sales_price"=>$v->product_sales_price,
                "detail_extra"=>$v->detail_extra,
                "detail_quantity"=>$v->detail_quantity,
                "detail_cost"=>$v->detail_cost,
                "detail_status"=>$v->detail_status,
                "detail_extra"=>$product,
            ];
        }
        $array_order[0]['detail']=$array_detail;
        return response()->json([
            "data"=>$array_order,
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        try
        {
            order_order::where('id',$id)
            ->where('tbl_order_order.id_business',Auth::user()->id_business)
            ->update(["order_status"=>6,"order_comment"=>$request->order_comment]);
            return response()->json([
                'status'=>200,
                 'message'=>'Hủy đơn hàng thành công',
            ]);

        }
        catch(Exception $e)
        {
            return response()->json([
                'status'=>200,
                 'message'=>'Hủy đơn hàng thất bại thất bại',
            ]);
        }
    }
}
