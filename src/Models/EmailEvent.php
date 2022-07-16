<?php

namespace Elfcms\Basic\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailEvent extends Model
{
    use HasFactory;

    public $emailFields = [
        'from',
        'to',
        'cc',
        'bcc'
    ];

    protected $fillable = [
        'code',
        'name',
        'subject',
        'description',
        'text',
        'contentparams'
    ];

    protected $casts = [
        'contentparams' => 'array',
    ];

    public $text, $subject, $attatch, $attatchData, $params=[];

    public function eventAddresses()
    {
        return $this->belongsToMany(EmailEventAddress::class);
    }

    public function addresses()
    {
        return $this->belongsToMany(EmailAddress::class, 'email_event_addresses')->get();
    }

    public function fields()
    {
        $result = [];

        $emailFieldList = $this->hasMany(EmailEventAddress::class, 'email_event_id')->get();

        /* foreach ($ef as $a=>$b) {
            dd($b->address()->get());
        } */
        //$emailFieldList = $this->hasMany(EmailEventAddress::class, 'email_event_id')->get()->toArray();

        foreach ($emailFieldList as $field) {
            //dd($field->address()->get());
            //$data = $field->address()->get();
            if (in_array($field->field, $this->emailFields)) {
                $result[$field->field] = $field->address()->first();
            }
        }

        return $result;
    }
}
