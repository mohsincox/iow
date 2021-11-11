<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BestSelling extends Model
{
    protected  $table =  'best_sellings';
    protected  $fillable = [ 'customer_id', 'order_id', 'product_id', 'number_of_product_sale'];
}
