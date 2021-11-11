<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use SoftDeletes;
    protected $table = 'coupons';
    protected $fillable = [
        'code', 'discount', 'discount_type', 'expire_date', 'status', 'is_public'
    ];
}
