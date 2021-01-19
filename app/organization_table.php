<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class organization_table extends Model
{
    protected $table = 'tbl_organization_table';
    protected $fillable = ['id','id_floor','table_title','table_status','id_business'];
    public $timestamps = false;
    protected $primaryKey = 'id';

}
