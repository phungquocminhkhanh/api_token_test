<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class order_order extends Model
{
    protected $table = 'tbl_order_order';
    protected $fillable = ['id',
                            'id_business',
                            'id_account',
                            'id_customer',
                            'order_floor',
                            'order_table',
                            'order_code',
                            'order_location',
                            'order_status',
                            'order_direct_discount',
                            'order_point_discount',
                            'order_total_cost',
                            'order_comment',
                            'order_created',
                            'order_check_time'
                        ];
    public $timestamps = false;
    protected $primaryKey = 'id';
}
