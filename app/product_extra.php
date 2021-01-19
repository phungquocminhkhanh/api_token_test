<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class product_extra extends Model
{
    protected $table = 'tbl_product_extra';
    protected $fillable = ['id',
                            'id_product',
                            'id_product_extra',
                            'id_business'
                        ];
    public $timestamps = false;
    protected $primaryKey = 'id';
}
