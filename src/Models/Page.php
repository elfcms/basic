<?php

namespace Elfcms\Basic\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'name',
        'title',
        'content',
        'meta_keywords',
        'meta_description'
    ];
}
