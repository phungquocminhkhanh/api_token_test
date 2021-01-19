<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class app_deploy extends Model
{
    protected $table = 'tbl_app_deploy';
    protected $fillable = ['id','live_version'];
    public $timestamps = false;
    protected $primaryKey = 'id';
}
