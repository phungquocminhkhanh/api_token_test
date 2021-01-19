<?php

namespace App\Http\Controllers\admin_board;

use App\Http\Controllers\Controller;
use App\product_product;
use App\product_unit;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class product_unitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(product_unit::where('id_business',Auth::user()->id_business)->get());
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
        $unit=product_unit::where('unit_title',$request->unit_title)->where('id_business',Auth::user()->id_business)->get();
        if(count($unit)>0)
        {
            return response()->json([
                'status'=>300,
             'message'   => 'Tên đơn vị này đã được sử dụng',
            ]);
        }
        else
        {


                $unit=new product_unit();
                $unit->id_business=Auth::user()->id_business;
                $unit->unit_title=$request->unit_title;
                $unit->unit=$request->unit;
                $unit->save();
                return response()->json([
                    'status'=>200,
                 'message'   => 'Thêm thành công',
                ]);

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
        $cate=product_unit::where('id',$id)->where('id_business',Auth::user()->id_business)->get();

        return response()->json([
            'status'   => 200,
            'data'=>$cate
           ]);
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
            $check=product_unit::where('unit_title',$request->unit_title)
            ->whereNotIn('id',[$id])
            ->where('id_business',Auth::user()->id_business)->get();
            if(count($check)>0)
            {
                return response()->json([
                    'status'=>300,
                     'message'=>$request->unit_title.' đã tồn tại',
                ]);
            }
            else
            {
                $unit= product_unit::where('id',$id)
                ->update(["unit_title"=>$request->unit_title,
                "unit"=>$request->unit]);
                return response()->json([
                    'status'=>200,
                     'message'=>'Cập nhật thành công',
                ]);
            }


        }
        catch(Exception $e)
        {
            return response()->json([
                'status'=>200,
                 'message'=>$request->unit_title,
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $product=product_product::where('id_unit',$request->id_unit)->get();

        DB::beginTransaction();
            try {
                if(count($product)>0)
                {
                    return response()->json([
                        'status'=>200,
                         'message'=>'Không thể xóa đơn vị này.',
                    ]);
                }
                else
                {
                    DB::table('tbl_product_unit')
                    ->where('id',$request->id_unit)
                    ->where('id_business',Auth::user()->id_business)
                    ->delete();
                    DB::commit();
                    return response()->json([
                        'status'=>200,
                         'message'=>'Xóa đơn vị thành công',
                    ]);
                }

             } catch (Exception $e) {
                 DB::rollBack();

                    throw new Exception($e->getMessage());
        }
    }
}
