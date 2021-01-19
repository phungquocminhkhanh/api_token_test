<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class order_detail extends Model
{
    protected $table = 'tbl_order_detail';
    protected $fillable = ['id','id_order','id_product','detail_quantity','detail_status','detail_cost','id_business'];
    public $timestamps = false;
    protected $primaryKey = 'id';
}
