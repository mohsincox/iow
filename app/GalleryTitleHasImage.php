<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GalleryTitleHasImage extends Model
{
    use SoftDeletes;

    protected $table = "gallery_title_has_image";
    protected $fillable = ['title_id', 'image'];
}
