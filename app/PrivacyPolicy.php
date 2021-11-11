<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrivacyPolicy extends Model
{
    protected $table = 'privacy_polices';
    protected $fillable = ['id','des'];
}
