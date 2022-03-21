<?php

namespace App\Http\Controllers;

use App\Banktable;
use App\Member;
use App\Saving;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SavingsWithdrawalController extends Controller
{
    public function checkSavingsWithdrawalPaymentStatus()
    {
        $checkExistingLoanApplication = DB::Table('applications')->where('type','Savings Withdrawal')->where('user_id',Auth::id())->first();
            if(!empty($checkExistingLoanApplication)):
                if($checkExistingLoanApplication->user_id  && $checkExistingLoanApplication->status == 'Rejected' && $checkExistingLoanApplication->type == 'Savings Withdrawal'):
                    return redirect('/accountActivation/makePayment');
                elseif ($checkExistingLoanApplication->user_id && $checkExistingLoanApplication->status == 'Processing' && $checkExistingLoanApplication->type == 'Savings Withdrawal'):
                    return redirect()->back()->with('warning','Your last withdrawal request is still being processed.');
                elseif($checkExistingLoanApplication->user_id  && $checkExistingLoanApplication->status == 'Approved' && $checkExistingLoanApplication->type == 'Savings Withdrawal'):
                    return redirect('/accountActivation/makePayment');
                else:
                    return $this->SavingsWithdrawalForm();
                endif;
            else:
                return redirect('/accountActivation/makePayment');
            endif;
    }
    private function SavingsWithdrawalForm()
    {
        $acc_bal = DB::table('savings')->where('user_id',Auth::id())
            ->orderByDesc('id')->limit(1)->value('balance');
        $savings = Saving::where('user_id',Auth::id())->orderByDesc('id')->get();
        $banks = Banktable::pluck('bank_name','id')->toArray();
        return view('dashboard.withdrawals.makeWithdrawal',compact('acc_bal','savings','banks'));
    }

    public function showSavingsWithdrawalsTransactions()
    {
        $savings = Saving::where('user_id',Auth::id())->orderByDesc('id')->get();
        \App\Helpers\LogActivity::logUserActivity(' User Visited Savings and Withdrawal Transaction Page');
        return view('dashboard.withdrawals.withdrawalTransactions',compact('savings'));
    }

    public function submitSavingsWithdrawal(Request $request)
    {
            $current_date = date('Y-m-d');
            $withdrawal_amount = str_replace(',','',$request->with_amount);
            $acc_bal = DB::table('savings')->where('user_id',Auth::id())
                       ->orderByDesc('id')->limit(1)->value('balance');
            if( !($withdrawal_amount > $acc_bal) ){
                $createWithdrawalRequest = Saving::create([
                    'user_id' => Auth::id(),
                    'description' => 'Savings Withdrawal',
                    'amount_withdrawn' => $withdrawal_amount,
                    'month' => $current_date,
                    'status' => 'Processing',
                    'ippis_no' => Auth::user()->ippis_no,
                ]);

                //saving withdrawal notification
                $user_details = User::where('id',Auth::id())->first();
                $admin_email = User::where('is_admin',true)->pluck('email')->all();//collect emails of all admin users
                $withdrawal_details = [
                    'user_email' => $user_details->email,
                    'user_name' => $user_details->name,
                    'admin_email' => $admin_email,
                    'withdrawal_amount' => $withdrawal_amount,
                ];

                (new MailController)->submitSavingWithdrawalRequest($withdrawal_details);

                \App\Helpers\LogActivity::logUserActivity(' User Submitted Savings Withdrawal Request');

                if($createWithdrawalRequest){
                    $data = ['success' => true, 'message'=> "Withdrawal Request Successfully Submitted"];
                    return response()->json($data);
                }

            }else{
                $data = ['warning' => true, 'message'=> "Available balance not sufficient"];
                return response()->json($data);
            }

    }

}
