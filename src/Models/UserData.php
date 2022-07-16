<?php

namespace Elfcms\Basic\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserData extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'first_name',
        'second_name',
        'last_name',
        'zip_code',
        'country',
        'city',
        'street',
        'house',
        'full_address',
        'phone_code',
        'phone_number',
        'photo',
        'thumbnail'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
