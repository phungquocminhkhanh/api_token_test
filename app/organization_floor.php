<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class organization_floor extends Model
{
    protected $table = 'tbl_organization_floor';
    protected $fillable = ['id','id_business','floor_priority','floor_title','floor_type'];
    public $timestamps = false;
    protected $primaryKey = 'id';//
}
