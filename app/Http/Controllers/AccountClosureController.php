<?php

namespace App\Http\Controllers;

use App\Application;
use App\Charges;
use App\Loan;
use App\Member;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Translation\Extractor\ChainExtractor;

class AccountClosureController extends Controller
{
    //
    public function closeUserAccount(Request $request)
    {
        //check if the has outstanding loan payment
        $checkLoan = Loan::where('user_id',Auth::id())->first();
        if($checkLoan){
            if($checkLoan->user_id  && $checkLoan->status == 'Approved'){
                return redirect()->back()->with('warning','You cannot close your account while you still have outstanding loan to repay. Kindly offset your loan balance before closing your account!');
            }else{
                return view('dashboard/accountActivation/accountClosurePayment');
            }
        }else{
            $paymentCharges = Charges::all();
            return view('dashboard/accountActivation/makePayment',compact('paymentCharges'));
        }
    }

    public function showAccountClosureSuccess(Request $request)
    {
        Member::where('user_id',Auth::id())->update([
             'membership_status' => 'Archived',
        ]);

        Application::where('user_id',Auth::id())->delete();

        User::where('id',Auth::id())->update([
            'membership_renewal_status' => '',
        ]);

        User::find(Auth::id())->delete();

        $request->session()->flush();
        return view('auth/shield/accountClosure');
    }
}
