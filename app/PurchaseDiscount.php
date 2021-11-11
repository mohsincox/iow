<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseDiscount extends Model
{
    use SoftDeletes;
    protected $table = "purchase_discounts";
    protected $fillable= ['offer_type','discount','discount_amount_type','expire_date','number_of_purchase','purchase_start_date','purchase_end_date','status'
    ];
}
