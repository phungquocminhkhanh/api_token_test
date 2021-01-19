<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class customer_point extends Model
{
    protected $table = 'tbl_customer_point';
    protected $fillable = ['id','id_business','customer_level','customer_point','customer_discount','customer_description'];
    public $timestamps = false;
    protected $primaryKey = 'id';
}
