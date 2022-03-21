<?php

namespace App\Http\Controllers;

use App\Charges;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShowPaymentFormController extends Controller
{
    //
    public function index()
    {
        if(Auth::check())
        {
            if(isset($_SERVER['HTTP_REFERER'])):
                $paymentCharges = Charges::all();
                return view('dashboard.accountActivation.makePayment',[
                    'paymentCharges' => $paymentCharges,
                ]);
            else:
                \App\Helpers\LogActivity::logUserActivity(' User tried to visit payment page wrongly');
                return redirect('/dashboard/home');
            endif;
        }

    }
}
