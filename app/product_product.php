<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class product_product extends Model
{
    protected $table = 'tbl_product_product';
    protected $fillable = ['id',
                            'id_business',
                            'id_category',
                            'id_unit',
                            'product_img',
                            'product_title',
                            'product_code',
                            'product_sales_price',
                            'product_description',
                            'product_point',
                            'product_disable',
                            'product_sold_out'
                        ];
    public $timestamps = false;
    protected $primaryKey = 'id';
    public function get_product()
    {
        $product=DB::table('tbl_product_product')
        ->where('product_disable','N')
        ->where('id_business',Auth::user()->id_business)->get();
        return $product;
    }
}
