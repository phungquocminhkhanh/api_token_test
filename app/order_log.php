<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class order_log extends Model
{
    protected $table = 'tbl_order_log';
    protected $fillable = ['id','id_order','log_status','time_log','id_business'];
    public $timestamps = false;
    protected $primaryKey = 'id';
}
