<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class account_authorize extends Model
{
    protected $table = 'tbl_account_authorize';
    protected $fillable = ['id','id_admin','grant_permission','id_business'];
    public $timestamps = false;
    protected $primaryKey = 'id';
}
