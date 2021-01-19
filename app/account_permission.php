<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class account_permission extends Model
{
    protected $table = 'tbl_account_permission';
    protected $fillable = ['id','permission','description','id_business'];
    public $timestamps = false;
    protected $primaryKey = 'id';
}
