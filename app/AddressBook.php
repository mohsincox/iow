<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AddressBook extends Model
{
    use SoftDeletes;
    protected $table = 'address_books';
    protected $fillable = [
        'customer_id', 'name', 'phone', 'email', 'company_name', 'country', 'address_name', 'address', 'appartment', 'city', 'postal_code', 'status'
    ];
}
