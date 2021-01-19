<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class customer_customer extends Model
{
    protected $table = 'tbl_customer_customer';
    protected $fillable = ['id',
                            'id_business',
                            'id_account',
                            'customer_code',
                            'customer_name',
                            'customer_phone',
                            'customer_sex',
                            'customer_email',
                            'customer_birthday',
                            'customer_address',
                            'customer_point',
                            'customer_taxcode',
                        ];
    public $timestamps = false;
    protected $primaryKey = 'id';
}
