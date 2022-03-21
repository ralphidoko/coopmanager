<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ElectionController extends Controller
{
    //

    public function showElectionPage()
    {
        return view('dashboard.elections.electionCenter');
    }
}
