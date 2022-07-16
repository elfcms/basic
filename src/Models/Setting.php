<?php

namespace Elfcms\Basic\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'name',
        'params',
        'value',
        'description_code',
    ];

    public static function value($code)
    {
        return self::where('code',$code)->first()->value ?? null;
    }

    public static function get()
    {
        $all = self::all();
        $result = [];
        foreach ($all as $item) {
            $result[$item['code']] = $item;
        }

        return $result;
    }

    public static function values()
    {
        $all = self::all();
        $result = [];
        foreach ($all as $item) {
            $result[str_ireplace('site_','',$item['code'])] = $item->value;
        }

        return $result;
    }
}
