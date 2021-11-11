<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;


class Product extends Model
{
    use SoftDeletes;
    use Sluggable;
    protected  $table = 'products';
    protected  $fillable = [ 'category_id','sub_category_id','name','slug', 'discount', 'price','selling_price','quantity','sku','description', 'thumbnail_image'];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}
