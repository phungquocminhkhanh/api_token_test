<?php

namespace App\Http\Controllers\admin_board;

use App\Http\Controllers\Controller;
use App\order_detail;
use Illuminate\Http\Request;
use App\product_product;
use App\product_unit;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Facades\DB;
use App\product_extra;
use FFI\Exception;

class product_productController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        $product=new product_product();
        return response()->json($product->get_product());

    }
    public function get_unit()
    {
        $unit=DB::table('tbl_product_unit')->where('id_business',Auth::user()->id_business)->get();
        return response()->json($unit);
    }
    public function product_seach(Request $request)
    {
        $id_bu=Auth::user()->id_business;
        $sql="select * from tbl_product_product where 1=1 and id_business='$id_bu'";
        if($request->product_disable)
        {
            $sql.=" and product_disable='$request->product_disable'";
        }
        if($request->id_category)
        {
            if($request->id_category!=0)
            {
                $sql.=" and id_category='$request->id_category'";
            }

        }
        if($request->id_product)
            $sql.="and id=$request->id_product";
        $product=DB::select($sql);
        if($request->id_product)
        {
                $acc=DB::table('tbl_product_product')
            ->join('tbl_product_extra','tbl_product_extra.id_product','=','tbl_product_product.id')
            ->select('tbl_product_extra.id as extra_id',
            'tbl_product_product.product_title as product_title',
            DB::raw('(select tbl_product_product.product_title from tbl_product_product where tbl_product_product.id=tbl_product_extra.id_product_extra) as extra_title'))
            ->where('tbl_product_extra.id_product',$product[0]->id)
            ->where('tbl_product_product.id_business',$id_bu)
            ->get();
            if(count($acc)>0)
            {
                return response()->json([
                    'status'=>200,
                    'product'=>$product,
                    'extra'=>$acc
                ]);
            }
            else
            {
                return response()->json([
                    'status'=>200,
                    'product'=>$product
                ]);
            }
        }
        return response()->json([
            'status'=>200,
            'data'=>$product,
        ]);
    }
    public function product_seach_auto(Request $request)//bấm cái gì thì nó tự hiểu và seach cái đó
    {
        $id=Auth::user()->id_business;
        $sql="";
        $price=(int)$request->key_seach;
        if($request->key_seach)
        {
            if($request->id_category)
            {
                $sql="select * from tbl_product_product where id_business=$id
                and id_category=$request->id_category and product_disable='N'
                 and (product_title like '%$request->key_seach%'
                 or product_sales_price<='$price'
                 or product_code like '%$request->key_seach%')";
                if($request->product_disable)
                {
                    $sql="select * from tbl_product_product where id_business=$id
                    and id_category=$request->id_category and product_disable=$request->product_disable
                     and (product_title like '%$request->key_seach%'
                     or product_sales_price<='$price'
                     or product_code like '%$request->key_seach%')";
                }
                $product =DB::select($sql);
                return response()->json([
                    'status'=>200,
                    'data'=>$product
                ]);

            }
            if($request->product_disable)
            {
                $sql="select * from tbl_product_product where id_business=$id
                and product_disable='$request->product_disable'
                 and (product_title like '%$request->key_seach%'
                 or product_sales_price<='$price'
                 or product_code like '%$request->key_seach%')";
                if($request->id_category)
                {
                    $sql="select * from tbl_product_product where id_business=$id
                    and id_category=$request->id_category and product_disable='$request->product_disable'
                     and (product_title like '%$request->key_seach%'
                     or product_sales_price<='$price'
                     or product_code like '%$request->key_seach%')";
                }
                $product =DB::select($sql);
                return response()->json([
                    'status'=>200,
                    'data'=>$product
                ]);
            }
            else
            {

                $sql="select * from tbl_product_product where id_business=$id
                and product_disable='N'
                 and (product_title like '%$request->key_seach%'
                 or product_sales_price<='$price'
                 or product_code like '%$request->key_seach%')";
            $product =DB::select($sql);
            return response()->json([
                'status'=>200,
                'data'=>$product
            ]);
            }

        }
        else
        {
            if($request->id_category)
            {
                $product=DB::table('tbl_product_product')
                ->where('id_business',Auth::user()->id_business)
                ->where('product_disable','N')
                ->where('id_category',$request->id_category)->get();
            }
            else
            {
                $product=DB::table('tbl_product_product')
                ->where('product_disable','N')
                ->where('id_business',Auth::user()->id_business)
                ->get();
            }
        }

        return response()->json([
            'status'=>200,
            'data'=>$product
        ]);
    }
    public function product_disable(Request $request)//bấm cái gì thì nó tự hiểu và seach cái đó
    {
        product_product::where('id',$request->id_product)->where('id_business',Auth::user()->id_business)->update(['product_disable'=>$request->status_product]);
        $acc=product_product::where('id',$request->id_product)->get();
        return response()->json([
            'success' => 200,
            'data'=>$acc
        ],200);
    }
    public function insert_product_extra(Request $request)
    {
        $list=$request->list_product_extra;
        foreach($list as $k=>$v)
        {
            $check=product_extra::where('id_product',$request->id_product)
            ->where('id_business',Auth::user()->id_business)
            ->where('id_product_extra',$v)->get();
            if(count($check)>0)
            {

            }
            else
            {
                $extra=new product_extra;
                $extra->id_product=$request->id_product;
                $extra->id_product_extra=$v;
                $extra->id_business=Auth::user()->id_business;
                $extra->save();
            }

        }
        return response()->json([
            'status'=>200,
         'message'   => 'Thêm thành công',
        ]);
    }
    public function detele_extra(Request $request)
    {
        $d=DB::table('tbl_product_extra')->where('id',$request->extra_id)->delete();
        if($d)
        {
            return response()->json([
                'status'=>200,
                'message'=> 'Xóa thành công',
            ]);
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
        $checkcode=product_product::where('product_code',$request->product_code)
        ->where('id_business',Auth::user()->id_business)->get();
        if(count($checkcode)>0)
        {
            return response()->json([
                'status'=>300,
             'message'   => 'Mã sản phẩm đã được sử dụng',
            ]);
        }
        else
        {
            $validation = Validator::make($request->all(), [
                'select_file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
               ]);
               if($validation->passes())
               {
                $image = $request->file('select_file');
                $new_name = rand() . '.' . $image->getClientOriginalExtension();
                $image->move('../../images/product_product', $new_name);

                $product=new product_product;
                $product->id_business=Auth::user()->id_business;
                $product->id_category=$request->id_category;
                $product->id_unit=$request->id_unit;
                $product->product_img='images/product_product/'.$new_name;
                $product->product_title=$request->product_title;
                $product->product_code=$request->product_code;
                $product->product_sales_price=$request->product_sales_price;

                if($request->product_description)
                    $product->product_description=$request->product_description;
                else
                    $product->product_description=" ";

                if($request->product_point)
                    $product->product_point=$request->product_point;
                else
                    $product->product_point=0;
                $product->save();
                return response()->json([
                    'status'=>200,
                 'message'   => 'Thêm thành công',
                ]);
               }
               else
               {
                return response()->json([
                 'message'   => "Thêm thất bại",
                ]);
               }
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
        $product=DB::table('tbl_product_product')
        ->where('id_business',Auth::user()->id_business)
        ->where('product_disable','N')
        ->where('id',$id)
        ->get();
        $unit=DB::table('tbl_product_unit')->where('id_business',Auth::user()->id_business)->get();
        $category=DB::table('tbl_product_category')->where('id_business',Auth::user()->id_business)->get();
        return response()->json([
            "status"=>200,
            "product"=>$product,
            "unit"=>$unit,
            "category"=>$category
        ]);
    }
    public function product_update(Request $request)
    {
        $checkcode=product_product::where('product_code',$request->product_code)
        ->whereNotIn('id',[$request->id_product])
        ->where('id_business',Auth::user()->id_business)->get();
        if(count($checkcode)>0)
        {
            return response()->json([
                'status'=>300,
             'message'   => 'Mã sản phẩm đã được sử dụng',
            ]);
        }
        else
        {
            if($request->check_upload_image==1)
            {
                $pro=product_product::where('id',$request->id_product)->where('id_business',Auth::user()->id_business)->get();
                    $filePath ="../../".$pro[0]->product_img;
                    if (file_exists($filePath))
                        unlink($filePath);// xoa ảnh củ

                $validation = Validator::make($request->all(), [
                    'select_file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
                   ]);
                   if($validation->passes())
                   {
                    $image = $request->file('select_file');
                    $new_name = rand() . '.' . $image->getClientOriginalExtension();
                    $image->move("../../images/product_product", $new_name);
                    $url='images/product_product/'.$new_name;

                    $des=" ";
                    $point=0;
                    if($request->product_description)
                        $des=$request->product_description;
                    else
                        $des=" ";


                    if($request->product_point)
                         $point=$request->product_point;
                    else
                         $point=0;

                    product_product::where('id',$request->id_product)
                    ->update(["id_category"=>$request->id_category,
                    "id_unit"=>$request->id_unit,
                    "product_img"=>$url,
                    "product_title"=>$request->product_title,
                    "product_code"=>$request->product_code,
                    "product_sales_price"=>$request->product_sales_price,
                    "product_description"=>$des,
                    "product_point"=>$point,
                    ]);
                    return response()->json([
                        'status'=>200,
                     'message'   => 'Cập nhật thành công',
                    ]);
                   }
                   else
                   {
                    return response()->json([
                        'status'=>200,
                         'message'=>'Cập nhật thất bại',
                    ]);
                   }
            }
            else
            {
                // product_category::where('id',$id)->update(["category_title"=>$request->category_title]);
                if($request->product_description)
                        $des=$request->product_description;
                    else
                        $des=" ";


                    if($request->product_point)
                         $point=$request->product_point;
                    else
                         $point=0;
                    product_product::where('id',$request->id_product)
                    ->update(["id_category"=>$request->id_category,
                    "id_unit"=>$request->id_unit,
                    "product_title"=>$request->product_title,
                    "product_code"=>$request->product_code,
                    "product_sales_price"=>$request->product_sales_price,
                    "product_description"=>$des,
                    "product_point"=>$point,
                    ]);
                    return response()->json([
                        'status'=>200,
                         'message'=>'Cập nhật thành công',
                    ]);
            }

        }

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
        $order=order_detail::where('id_product',$request->id_product)->get();

        DB::beginTransaction();
            try {
                if(count($order)>0)
                {
                    return response()->json([
                        'status'=>200,
                         'message'=>'Không thể xóa sản phẩm đã có đơn hàng, bạn chỉ có thể ngừng bán sản phẩm',
                    ]);
                }
                else
                {
                    $pro=product_product::where('id',$request->id_product)->where('id_business',Auth::user()->id_business)->get();
                    $filePath ="../../".$pro[0]->product_img;
                    if (file_exists($filePath))
                        unlink($filePath);// xoa ảnh củ

                    DB::table('tbl_product_product')
                    ->where('id',$request->id_product)
                    ->where('id_business',Auth::user()->id_business)
                    ->delete();
                    DB::commit();
                    return response()->json([
                        'status'=>200,
                         'message'=>'Xóa sản phẩm thành công',
                    ]);
                }

             } catch (Exception $e) {
                 DB::rollBack();

                    throw new Exception($e->getMessage());
        }
    }
}
