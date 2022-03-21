<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UpdateUserProfile extends Controller
{
    //

    public function showUserData(Request $request)
    {

        return view('dashboard.updateUserProfile');

    }
}
