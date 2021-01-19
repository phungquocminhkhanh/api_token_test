<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class product_unit extends Model
{
    protected $table = 'tbl_product_unit';
    protected $fillable = ['id',
                            'unit_title',
                            'unit',
                            'id_business'
                        ];
    public $timestamps = false;
    protected $primaryKey = 'id';
}
