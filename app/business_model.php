<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class business_model extends Model
{
    protected $table = 'tbl_business_model';
    protected $fillable = ['id','id_business','business_model'];
    public $timestamps = false;
    protected $primaryKey = 'id';
}
