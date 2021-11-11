<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sub_category extends Model
{
    use SoftDeletes, Sluggable;
    protected $table = 'sub_categories';
    protected  $fillable = [ 'name', 'category_id', 'status', 'deleted_at'];

  /**
   * Return the sluggable configuration array for this model.
   *
   * @return array
   */
  public function sluggable()
  {
    return [
      'slug' => [
        'source' => 'name'
      ]
    ];
  }
}
