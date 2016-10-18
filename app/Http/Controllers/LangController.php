<?php

namespace App\Http\Controllers;


use App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class LangController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function change($lang)
    {
        if (in_array($lang, config('app.available_languages'))) {
            Session::set('applocale', $lang);
            Session::save();
            App::setLocale($lang);
            
            // Save user preferred lang 
            if ($user = Auth::user()) {
                $user->lang = $lang;
                $user->save();
            }
        }
        
        return redirect('/');
    }
}
