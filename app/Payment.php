<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected  $table =  'payments';
    protected  $fillable = [ 'order_id', 'customer_id', 'paid_by', 'transaction_id', 'type', 'amount', 'status'];
}
