<?php

namespace App\Http\Controllers;


use App;
use Illuminate\Support\Facades\Session;

class LangController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function change($lang)
    {echo 'lang controller <br />';
        if (in_array($lang, config('app.available_languages'))) {
            Session::set('applocale', $lang);
            Session::save();
            App::setLocale($lang);
        }
        
        return redirect('/');
    }
}
