<?php

namespace App\Http\Controllers\admin_board;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\product_category;
use App\account_permission;
use App\product_product;
use App\product_unit;
use Facade\FlareClient\Stacktrace\File;
use FFI\Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;
class product_categoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return response()->json(product_category::where('id_business',Auth::user()->id_business)->get());
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

        $cate=product_category::where('category_title',$request->category_title)
        ->where('id_business',Auth::user()->id_business)
        ->get();
        if(count($cate)>0)
        {
            return response()->json([
                'status'=>300,
             'message'   => 'Tên danh mục này đã được sử dụng',
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
                $image->move('../../images/product_category', $new_name);

                $category=new product_category;
                $category->id_business=Auth::user()->id_business;
                $category->category_icon='images/product_category/'.$new_name;
                $category->category_title=$request->category_title;
                $category->save();
                return response()->json([
                    'status'=>200,
                 'message'   => 'Thêm thành công',
                ]);
               }
               else
               {
                return response()->json([
                    'status'=>200,
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
        $cate=product_category::where('id',$id)->get();

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
    public function product_category_update(Request $request)
    {
        $cate=product_category::where('category_title',$request->category_title)
        ->whereNotIn('id',[$request->id_category])->get();
        if(count($cate)>0)
        {
            //$a=$_SERVER['SERVER_NAME'].dirname($_SERVER['PHP_SELF']);
            return response()->json([
                'status'=>300,
             'message'   => 'Tên danh mục này đã được sử dụng',
            ]);
        }
        else
        {
            if($request->check_upload_image==1)
            {
                $cate=DB::table('tbl_product_category')
                    ->where('id',$request->id_category)
                    ->where('id_business',Auth::user()->id_business)->get();
                    $filePath ="../../".$cate[0]->category_icon;

                    if (file_exists($filePath))
                        unlink($filePath);// xoa ảnh củ

                $validation = Validator::make($request->all(), [
                    'select_file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
                   ]);
                   if($validation->passes())
                   {
                    $image = $request->file('select_file');
                    $new_name = rand() . '.' . $image->getClientOriginalExtension();
                    $image->move('../../images/product_category', $new_name);
                    $url='images/product_category/'.$new_name;
                    product_category::where('id',$request->id_category)->update(["category_icon"=>$url,"category_title"=>$request->category_title]);
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
                product_category::where('id',$request->id_category)->update(["category_title"=>$request->category_title]);
                    return response()->json([
                        'status'=>200,
                         'message'=>'Cập nhật thành công',
                    ]);
            }
        }


    }
    public function update(Request $request, $id)
    {


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $product=product_product::where('id_category',$request->id_category)->get();

        DB::beginTransaction();
            try {
                if(count($product)>0)
                {
                    return response()->json([
                        'status'=>200,
                         'message'=>'Không thể xóa danh mục có sản phẩm',
                    ]);
                }
                else
                {
                    $cate=DB::table('tbl_product_category')
                    ->where('id',$request->id_category)
                    ->where('id_business',Auth::user()->id_business)->get();
                    $filePath ="../../".$cate[0]->category_icon;

                    if (file_exists($filePath))
                        unlink($filePath);
                    DB::table('tbl_product_category')
                    ->where('id',$request->id_category)
                    ->where('id_business',Auth::user()->id_business)
                    ->delete();
                    DB::commit();
                    return response()->json([
                        'status'=>200,
                         'message'=>'Xóa danh mục thành công',
                    ]);
                }

             } catch (Exception $e) {
                 DB::rollBack();

                    throw new Exception($e->getMessage());
        }
    }
}
