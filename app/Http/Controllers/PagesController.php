<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use UntitledDevelopers\KockatoosAdminCore\Http\Controllers\Controller;

class PagesController extends Controller
{
    public function index()
    {
        if (Auth::user() == null)
            return redirect('login');

        return view('app', [

        ]);
    }

    public function login()
    {
        if (Auth::user() != null)
            return redirect('/');

        return view('login');
    }
}
