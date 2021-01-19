<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class product_category extends Model
{
    protected $table = 'tbl_product_category';
    protected $fillable = ['id',
                            'id_business',
                            'category_icon',
                            'category_title'
                        ];
    public $timestamps = false;
    protected $primaryKey = 'id';
}
