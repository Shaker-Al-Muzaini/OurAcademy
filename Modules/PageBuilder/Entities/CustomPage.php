<?php

namespace Modules\PageBuilder\Entities;

use Illuminate\Database\Eloquent\Model;

class CustomPage extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'body',
        'status',
        'meta_keywords',
        'meta_description',
    ];
}
