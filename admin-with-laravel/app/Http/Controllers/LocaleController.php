<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LocaleController extends Controller
{
    public function setlocale($locale)
    {
        if (!in_array($locale, ['en', 'my'])) {
            abort(400);
        }

        session(['localization' => $locale]);
        return back();
    }
}
