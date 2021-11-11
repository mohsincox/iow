<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;


class Recipe extends Model
{
    // use Sluggable;
    use SoftDeletes;

    protected $table = "recipes";
    protected $fillable = [ 'blog_type', 'title', 'short_des', 'des', 'image','thumbnail_image','status'];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */

    // public function sluggable()
    // {
    //     return [
    //         'slug' => [
    //             'source' => 'title'
    //         ]
    //     ];
    // }
}
