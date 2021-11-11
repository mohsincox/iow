<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerGotPurchaseDiscount extends Model
{
    protected $table = "customer_got_purchase_discount";
    protected $fillable = [
        'customer_id', 'purchase_discount_id', 'purchase_discount'
    ];
}
