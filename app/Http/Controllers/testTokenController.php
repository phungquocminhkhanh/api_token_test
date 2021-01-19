<?php

namespace App\Http\Controllers;

use App\business_store;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;
use App\test;
class testTokenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return response()->json([
            'status'=>200,
             'message'=>'Khồng thể xóa tầng đã có bàn',
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
        //
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
    public function destroy($id,Request $request)
    {
         $headers = $request->header();

        $he= $headers['x-csrf-token'][0];
        return response()->json([
            'status'=>200,
             'message'=>'Khồng thể xóa tầng đã có bàn',
             'x-csrf-token'=>$he
         ]);
    }
    public function login(Request $request)
    {
        $bu=business_store::where('store_code',$request->store_code)->get();
        $idbu=(count($bu)>0)?$bu[0]->id:0;
        if (! $token = Auth::attempt(['account_username'=>$request->account_username,
        'account_password'=>$request->account_password,
        'id_business'=>$idbu
        ]))
        {
            return response()->json(['error' =>'pass, username khong dung'], 401);
        }
       // $client = ['subgsgsgs' => 'u0406'];

       // $payload = JWTFactory::sub('token')->data($client)->make();
       // $apy = JWTAuth::getPayload($token)->toArray();
        //$aaaaaa = JWTAuth::encode($payload)->get(); // mind the ->get()
        //$baaaaa=  JWTAuth::decode($payload)->get();
        //$a=date(d/m/YY,1611208313) // chuyen giay sang ngay thang nam
        return $this->respondWithToken($token);

    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()// chuyền cái token lên ,kiểm tra và trả về cái user nếu đúng
    {
        if(Auth::user())
        {
            return response()->json(Auth::user());
        }
        else
        {
            return response()->json(['token fail hoac het han su dung']);
        }

    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        Auth::logout();
        return response()->json(['message' => 'Dang xuat thanh cong']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(Auth::refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        $pay=array("fefe"=>"khanh","kkkk"=>"fefefe");
        $test=new test;
        $jwt=$test->encode($pay,'khanhdeptrai');
        //$date=new DateTime();
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth::factory()->getTTL() * 60 ,//mặc định là 60p, nếu muốn vào jwt.php thay đổi
            'test'=>$jwt
        ]);
    }
    public function load_page()
    {
        $a=Auth::user();
        if($a)
        {
            return response()->json([
                'ok' => 'OKOKOKOKO',
                'user'=>$a
            ]);
        }
        else
        {
            return response()->json([
                'fail' => 'fail'
            ]);
        }

    }
}
