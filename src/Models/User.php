<?php

namespace Elfcms\Basic\Models;

use App\Models\User as ModelsUser;
use Elfcms\Basic\Events\SomeMailEvent;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;

class User extends ModelsUser
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function data()
    {
        return $this->hasOne(UserData::class);
    }

    public function setConfirmationToken()
    {
        $token = Str::random(32);

        $this->confirm_token = $token;
        $this->save();

        return $this;
    }

    /* public function getConfirmationToken($send = true)
    {
        $token = Str::random(32);

        $this->confirm_token = $token;
        $this->save();

        if ($send) {
            event(new SomeMailEvent($this));
            //Mail::to($this->email)->send(new EmailConfirmation($this));
        }

        return $token;
    } */

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function assignRole(Role $role)
    {
        return $this->roles()->save($role);
    }

    public function isConfirmed()
    {
        return !! $this->is_confirmed;
    }

    public function fullname()
    {
        if (empty($this->data)) {
            return null;
        }
        return $this->data->first_name . ' ' .$this->data->second_name . ' ' .$this->data->last_name;
    }

    public function name($emailname = false)
    {
        $name = $this->fullname();

        if (empty(trim($name))) {
            $name = $this->name;
        }
        if (empty(trim($name))) {
            $name = $this->email;
            if ($emailname) {
                $name = stristr($name,'@',true);
            }
        }

        return $name;
    }
}
