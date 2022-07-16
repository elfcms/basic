<?php

namespace Elfcms\Basic\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description'
    ];

    public function items()
    {
        return $this->hasMany(MenuItem::class);
    }
}
