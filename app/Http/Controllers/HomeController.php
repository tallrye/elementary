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
     *
     * @return  \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('id', '!=', \Auth::user()->id)->get();
        return view('home', compact('users'));
    }

}
