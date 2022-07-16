<?php

namespace Elfcms\Basic\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmpUser extends Model
{
    use HasFactory;

    protected $fillable = ['uuid'];
}
