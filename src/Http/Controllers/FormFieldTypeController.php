<?php

namespace Elfcms\Basic\Http\Controllers;

use App\Http\Controllers\Controller;
use Elfcms\Basic\Models\FormFieldType;
use Illuminate\Http\Request;

class FormFieldTypeController extends Controller
{
    public function start()
    {
        $fft = new FormFieldType;
        $fft->start();
    }
}
