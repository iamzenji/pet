<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('pets.index');
    }

    // todo create manage user function here
    // ? to manage change user role , details and reset password
}
