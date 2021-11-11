<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected  $table =  'orders';
    protected  $fillable = [ 'customer_id', 'product_details', 'amount', 'coupon_code', 'discount', 'discount_type', 'billing_address', 'shipping_address', 'order_note', 'payment_type', 'payment_status', 'status'];
}
