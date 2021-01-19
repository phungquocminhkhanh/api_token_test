<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class business_store extends Model
{
    protected $table = 'tbl_business_store';
    protected $fillable = ['id','id_business_model','store_name','store_code','store_phone','store_address','store_prefix','store_created','store_expired'];
    public $timestamps = false;
    protected $primaryKey = 'id';
}
