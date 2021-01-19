<?php

namespace App\Http\Controllers\admin_board;

use App\Http\Controllers\Controller;
use App\organization_floor;
use App\organization_table;
use FFI\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class floorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(organization_floor::where('id_business',Auth::user()->id_business)->orderBy('floor_priority', 'asc')->get());
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
        $check=organization_floor::where('floor_priority',$request->floor_priority)
        ->where('id_business',Auth::user()->id_business)->get();
        if(count($check)>0)
        {
            return response()->json([
                'status'=>300,
             'message'   => 'Thứ tự ưu tiên đã được sử dụng',
            ]);
        }
        try
        {
            $check=organization_floor::where('floor_title',$request->floor_title)
            ->where('id_business',Auth::user()->id_business)
            ->get();
            if(count($check))
            {
                return response()->json([
                    'status'=>300,
                     'message'=>$request->floor_title.' đã tồn tại',
                ]);
            }
            else
            {
                $floor= new organization_floor;
                $floor->id_business=Auth::user()->id_business;
                $floor->floor_priority=$request->floor_priority;
                $floor->floor_title=$request->floor_title;
                $floor->floor_type=$request->floor_type;
                $floor->save();
                return response()->json([
                    'status'=>200,
                     'message'=>'Thêm thành công',
                ]);
            }


        }
        catch(Exception $e)
        {
            return response()->json([
                'status'=>200,
                 'message'=>'Thêm thất bại',
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
        return response()->json(organization_floor::where('id_business',Auth::user()->id_business)
        ->where('id',$id)
        ->get());
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
        $check=organization_floor::where('floor_priority',$request->floor_priority)
        ->whereNotIn('id',[$id])
        ->where('id_business',Auth::user()->id_business)
        ->get();
        if(count($check)>0)
        {
            return response()->json([
                'status'=>300,
             'message'   => 'Thứ tự ưu tiên đã được sử dụng',
            ]);
        }
        try
        {
            $check=organization_floor::where('floor_title',$request->floor_title)
            ->whereNotIn('id',[$id])
            ->where('id_business',Auth::user()->id_business)
            ->get();
            if(count($check))
            {
                return response()->json([
                    'status'=>300,
                     'message'=>$request->floor_title.' đã tồn tại',
                ]);
            }
            else
            {
                $floor= organization_floor::where('id',$id)
                ->update(["floor_title"=>$request->floor_title,
                "floor_priority"=>$request->floor_priority,
                "floor_type"=>$request->floor_type]);
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
                 'message'=>'Cập nhật thất bại',
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

        $table=organization_table::where('id_floor',$request->id_floor)->get();//get table co trong floor

        DB::beginTransaction();
            try {
                if(count($table)>0)
                {
                   // $token = $request->session()->token();// lay doạn mã token
                    //$headers = $request->header();
                   // $he= $headers['authorization'][0];
                    return response()->json([
                        'status'=>200,
                         'message'=>'Khồng thể xóa tầng đã có bàn',
                     ]);
                }
                else
                {
                    organization_floor::where('id',$request->id_floor)->delete();
                    DB::commit();
                    return response()->json([
                        'status'=>200,
                         'message'=>'Xóa tầng thành công',
                    ]);
                }

             } catch (Exception $e) {
                 DB::rollBack();

                    throw new Exception($e->getMessage());
        }
    }
}
