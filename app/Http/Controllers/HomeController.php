<?php

namespace App\Http\Controllers;

use App\User;


class HomeController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Home Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the application dashboard, as well as the
    | redirected users if they are banned from the system 
    | and/or the IP address they're trying to login from is not valid. 
    |
    */

    /**
     * Show the application dashboard.
     */
    public function index()
    {
        return view('home');
    }

}
