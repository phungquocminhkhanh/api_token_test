<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Events\sendMessage;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Redirect;
use App\NhanVien;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//form

//real-time
//$i=1;
Route::get('/', function () {
    return view('admin.login');
});
Route::get('/dashboard', function () {
    $check=isset(Auth::user()->id)?Auth::user()->id:"";
    if($check)
    {
        $r=DB::table('tbl_account_authorize')
        ->join('tbl_account_permission','tbl_account_permission.id','=','tbl_account_authorize.grant_permission')
        ->select('tbl_account_permission.permission')
        ->where('tbl_account_authorize.id_admin',Auth::user()->id)
        ->where('tbl_account_authorize.id_business',Auth::user()->id_business)
        ->get();
        return view('admin.dashboard')->with("permission",$r);
    }
    return view('admin.login');
});

Route::group(['prefix' => 'page'], function () {
    Route::post('login', 'loginController@login');
    Route::get('logout', 'loginController@logout');
    Route::post('send-otp', 'loginController@send_otp');
});

Route::group(['prefix' => 'admin'], function () {

    Route::get('manage-account',['middleware' => 'auth.roles:module_employee', function () {
        $r=DB::table('tbl_account_authorize')
                ->join('tbl_account_permission','tbl_account_permission.id','=','tbl_account_authorize.grant_permission')
                ->select('tbl_account_permission.permission')
                ->where('tbl_account_authorize.id_admin',Auth::user()->id)
                ->where('tbl_account_authorize.id_business',Auth::user()->id_business)
                ->get();
        return view('admin.account')->with("permission",$r);
    }]);

    Route::get('manage-product-category',['middleware' => 'auth.roles:module_product', function () {
        $r=DB::table('tbl_account_authorize')
                ->join('tbl_account_permission','tbl_account_permission.id','=','tbl_account_authorize.grant_permission')
                ->select('tbl_account_permission.permission')
                ->where('tbl_account_authorize.id_admin',Auth::user()->id)
                ->where('tbl_account_authorize.id_business',Auth::user()->id_business)
                ->get();
        return view('admin.product-category')->with("permission",$r);
    }]);

    Route::get('manage-product-product',['middleware' => 'auth.roles:module_product', function () {
        $r=DB::table('tbl_account_authorize')
                ->join('tbl_account_permission','tbl_account_permission.id','=','tbl_account_authorize.grant_permission')
                ->select('tbl_account_permission.permission')
                ->where('tbl_account_authorize.id_admin',Auth::user()->id)
                ->where('tbl_account_authorize.id_business',Auth::user()->id_business)
                ->get();
        return view('admin.product-product')->with("permission",$r);
    }]);
    Route::get('manage-product-unit',['middleware' => 'auth.roles:module_product', function () {
        $r=DB::table('tbl_account_authorize')
                ->join('tbl_account_permission','tbl_account_permission.id','=','tbl_account_authorize.grant_permission')
                ->select('tbl_account_permission.permission')
                ->where('tbl_account_authorize.id_admin',Auth::user()->id)
                ->where('tbl_account_authorize.id_business',Auth::user()->id_business)
                ->get();
        return view('admin.product-unit')->with("permission",$r);
    }]);

    Route::get('manage-floor-table',['middleware' => 'auth.roles:module_floor', function () {
        $r=DB::table('tbl_account_authorize')
                ->join('tbl_account_permission','tbl_account_permission.id','=','tbl_account_authorize.grant_permission')
                ->select('tbl_account_permission.permission')
                ->where('tbl_account_authorize.id_admin',Auth::user()->id)
                ->where('tbl_account_authorize.id_business',Auth::user()->id_business)
                ->get();
        return view('admin.floor-table')->with("permission",$r);
    }]);

    Route::get('manage-customer',['middleware' => 'auth.roles:module_customer', function () {
        $r=DB::table('tbl_account_authorize')
                ->join('tbl_account_permission','tbl_account_permission.id','=','tbl_account_authorize.grant_permission')
                ->select('tbl_account_permission.permission')
                ->where('tbl_account_authorize.id_admin',Auth::user()->id)
                ->where('tbl_account_authorize.id_business',Auth::user()->id_business)
                ->get();
        return view('admin.customer')->with("permission",$r);
    }]);

    Route::get('manage-customer-level',['middleware' => 'auth.roles:module_customer', function () {
        $r=DB::table('tbl_account_authorize')
                ->join('tbl_account_permission','tbl_account_permission.id','=','tbl_account_authorize.grant_permission')
                ->select('tbl_account_permission.permission')
                ->where('tbl_account_authorize.id_admin',Auth::user()->id)
                ->where('tbl_account_authorize.id_business',Auth::user()->id_business)
                ->get();
        return view('admin.customer-level')->with("permission",$r);
    }]);

    Route::get('manage-order',['middleware' => 'auth.roles:module_order', function () {
        $r=DB::table('tbl_account_authorize')
                ->join('tbl_account_permission','tbl_account_permission.id','=','tbl_account_authorize.grant_permission')
                ->select('tbl_account_permission.permission')
                ->where('tbl_account_authorize.id_admin',Auth::user()->id)
                ->where('tbl_account_authorize.id_business',Auth::user()->id_business)
                ->get();
        return view('admin.order')->with("permission",$r);
    }]);

    Route::get('list-account-type', 'admin_board\viewController@list_account_type');
    Route::get('list-permission', 'admin_board\viewController@list_permission');

    Route::resource('account-account', 'admin_board\account_accountController');
    Route::post('list-manager', 'admin_board\account_accountController@list_manage');
    Route::post('account-account-permission', 'admin_board\account_accountController@account_permission');
    Route::post('account-account-detail', 'admin_board\account_accountController@account_detail');
    Route::post('account-account-disable', 'admin_board\account_accountController@account_disable');
    Route::post('account-account-change-password', 'admin_board\account_accountController@account_change_password');
    Route::post('account-account-change-password-dashboard', 'admin_board\account_accountController@account_change_password_dashboard');
    Route::post('account-account-get-permission', 'admin_board\account_accountController@get_permission');

    Route::resource('product-category', 'admin_board\product_categoryController');
    Route::post('product-category-update', 'admin_board\product_categoryController@product_category_update');

    Route::resource('product-unit', 'admin_board\product_unitController');


    // dua vao ham put update thi nos co bug
    Route::resource('product-product', 'admin_board\product_productController');
    Route::post('product-product-update', 'admin_board\product_productController@product_update');
    Route::get('product-product-unit', 'admin_board\product_productController@get_unit');
    Route::post('product-product-extra', 'admin_board\product_productController@insert_product_extra');
    Route::post('product-product-seach', 'admin_board\product_productController@product_seach');
    Route::post('product-product-seach-auto', 'admin_board\product_productController@product_seach_auto');
    Route::post('product-product-delete-extra', 'admin_board\product_productController@detele_extra');
    Route::post('product-product-disable', 'admin_board\product_productController@product_disable');

    Route::resource('floor', 'admin_board\floorController');

    Route::resource('table', 'admin_board\tableController');
    Route::post('get-table', 'admin_board\tableController@get_table');//lay table theo điều kiện
    Route::resource('product-product', 'admin_board\product_productController');

    Route::get('product-product-unit', 'admin_board\product_productController@get_unit');
    Route::post('product-product-extra', 'admin_board\product_productController@insert_product_extra');
    Route::post('product-product-seach', 'admin_board\product_productController@product_seach');
    Route::post('product-product-seach-auto', 'admin_board\product_productController@product_seach_auto');
    Route::post('product-product-delete-extra', 'admin_board\product_productController@detele_extra');


    Route::resource('customer-customer', 'admin_board\customer_customerController');
    Route::post('get-customer-customer', 'admin_board\customer_customerController@get_customer');
    Route::post('customer-customer-order', 'admin_board\customer_customerController@customer_order');
    Route::post('customer-seach', 'admin_board\customer_customerController@customer_seach');

    Route::resource('customer-point', 'admin_board\customer_pointController');
    Route::post('customer-point-customer', 'admin_board\customer_pointController@point_customer');//ds cus theo point


    Route::resource('order-order', 'admin_board\order_orderController');
    Route::post('order-order-detail', 'admin_board\order_orderController@order_order_detail');
    Route::post('get-order-order', 'admin_board\order_orderController@get_order_order');
});

