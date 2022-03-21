<?php

namespace App\Http\Controllers;

use App\Charges;
use App\Member;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class NewLoginController extends Controller
{
    //
    public function showNewLogin()
    {
        return view('auth.shield.new_login');
    }

    public function displayMembershipRenewalPaymentForm()
    {
        $paymentCharges = Charges::all();
        return view('dashboard.accountActivation.membershipRenewal',compact('paymentCharges'));
    }

    public function returningMemberLogin()
    {
        return view('auth.shield.returningMember');
    }

    public function renewMembership(Request $request)
    {
        $checkUserExistence = User::withTrashed()->where('email', $request->email)->orWhere('member_id',$request->member_id)->first();
        if($checkUserExistence == null){
            return redirect()->back()->with('error', "Wrong email or password");
        }elseif($checkUserExistence->deleted_at == null) {
            return redirect()->back()->with('error', "Action failed, your membership is still active");
        }elseif($checkUserExistence->email != $request->email) {
            return redirect()->back()->with('error', "Provided email doesn't match our record");
        }elseif ($checkUserExistence->member_id != $request->member_id) {
            return redirect()->back()->with('error', "Provided membership ID doesn't exist");
        }else{
            User::onlyTrashed()->where([['email', $request->email], ['member_id', $request->member_id]])->update([
                'password' => Hash::make($request->npassword),
            ]);
            $userEmail = $checkUserExistence->email;
            $memberID = $checkUserExistence->member_id;
            $userID = $checkUserExistence->id;
            return redirect('/accountActivation/membershipRenewal')->with('userEmail', $userEmail)->with('memberID', $memberID)->with('userID', $userID);
        }
   }
}
