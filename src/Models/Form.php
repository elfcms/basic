<?php

namespace Elfcms\Basic\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'title',
        'submit_button',
        'submit_name',
        'submit_title',
        'submit_value',
        'reset_button',
        'reset_title',
        'reset_value',
        'additional_buttons'
    ];

    public function fields()
    {
        return $this->hasMany(FormField::class, 'form_id')->orderBy('position');
    }

    public function fieldsWithoutGroup()
    {
        return $this->fields()->where('group_id',null);
    }

    public function groups()
    {
        return $this->hasMany(FormFieldGroup::class, 'form_id')->orderBy('position');
    }
}
