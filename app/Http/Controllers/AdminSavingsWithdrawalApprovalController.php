<?php

namespace App\Http\Controllers;

use App\Application;
use App\AuthorityToDeductPay;
use App\Saving;
use App\SavingAuthorization;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminSavingsWithdrawalApprovalController extends Controller
{

    public function showSavingsAuthorization()
    {
        $authorizations = SavingAuthorization::all()->sortByDesc('created_at');
        $deductions = AuthorityToDeductPay::all()->sortByDesc('created_at');;
        return view('dashboard.admin.savingsAuthorizations',compact('authorizations','deductions'));
    }

    public function showSavingsWithdrawal()
    {
        //get all savings
        $savings = Saving::where([['description','Savings Withdrawal']])->orderBy('created_at','desc')->get();
        return view('dashboard.admin.savingsWithdrawals',compact('savings'));
    }

    public function approveSavingsWithdrawalForm($saving_id)
    {
        $saving = DB::table('savings')->join('members','members.user_id','=','savings.user_id')->join('users','users.id','=','savings.user_id')
                  ->select('savings.*','members.staff_no','members.designation','members.department','members.office_location','users.passport_url','users.phone_no','users.name','users.member_id')->where([['savings.id',$saving_id],['savings.description','Savings Withdrawal']])->first();
        return view('dashboard.admin.savingsWithdrawalApproval',compact('saving'));
    }

    public function showSavingsWithdrawalsTransactions()
    {
        $user_ids = saving::all()->pluck('user_id');
        $users = User::with('savings')->whereIn('id',$user_ids)->paginate(20);
        return view('dashboard.admin.savingsWithdrawalsTransactions',compact('users'));
    }

    public function approveAuthToDeductPay(Request $request)
    {
        if(Auth::check()){
            $auth_id = $request->auth_id;
            $auth_user_id = AuthorityToDeductPay::whereIn('id',$auth_id)->pluck('user_id')->all();
            $auth_user_email = User::whereIn('id',$auth_user_id)->pluck('email')->all();

            $approval = AuthorityToDeductPay::whereIn('id', $auth_id)
                ->update([
                    'status' => 'Approved',
                ]);

            $deduct_pay_approval = [
                'user_email' => $auth_user_email,
            ];
            (new MailController)->authorityToDeductPayApprovalNotification($deduct_pay_approval);

            if($approval){
                $data = ['success' => true, 'message'=> "Authorization(s) Successfully Approved"];
                return response()->json($data);
            }

        }else{
            Auth::logout();
        }

    }

    public function approveIncreaseDecreaseSaving(Request $request)
    {
        if(Auth::check()){
            $inc_dec_ids = $request->inc_dec_id;
            $inc_dec_user_id = SavingAuthorization::whereIn('id',$inc_dec_ids)->pluck('user_id')->all();
            $inc_dec_id_user_email = User::whereIn('id',$inc_dec_user_id)->pluck('email')->all();
            $inc_dec_amounts = DB::table('saving_authorizations')->whereIn('id', $inc_dec_ids)->get();

            for($i=0; $i<count($inc_dec_amounts); $i++){
                for($i=0; $i<count($inc_dec_ids); $i++) {
                    $approval = SavingAuthorization::where('id', $inc_dec_ids[$i])
                        ->update([
                            'status' => 'Approved',
                            'current_amount' => $inc_dec_amounts[$i]->current_amount,
                        ]);

                    //update authority to deduct pay accordingly
                    AuthorityToDeductPay::where('user_id',$inc_dec_amounts[$i]->user_id)->update([
                        'authorized_amount' => $inc_dec_amounts[$i]->desired_amount,
                    ]);
                }
            }
            $deduct_pay_approval = [
                'user_email' => $inc_dec_id_user_email,
            ];
            //(new MailController)->authorityToDeductPayApprovalNotification($deduct_pay_approval);
            if($approval){
                $data = ['success' => true, 'message'=> "Increase/Decrease Savings Successfully Approved"];
                return response()->json($data);
            }

        }else{
            Auth::logout();
        }

    }
   //withdrawal approval
    public function approveSavingWithdrawalAction(Request $request)
    {
        if(Auth::check()){
            if($request->sec_approve){
                return $this->secApproveSavingWithdrawal($request);
            }elseif ($request->chair_approve){
                return $this->chairApproveSavingWithdrawal($request);
            }elseif ($request->reject_loan){
                return $this->rejectSavingsWithdrawal($request);
            }else{
                return $this->revokeSavingWithdrawal($request);
            }

        }else{
            Auth::logout();
        }
    }

    private function secApproveSavingWithdrawal(Request $request)
    {
        $secApproveWithdrawal =  Saving::where('id',$request->saving_id)->update([
            'sec_approve' => $request->sec_approve,
            'status' => 'Processing',
        ]);

        if($secApproveWithdrawal){
            $data = ['success' => true, 'message'=> "Withdrawal Approved by Secretary"];
            return response()->json($data);
        }
    }

    private function chairApproveSavingWithdrawal(Request $request)
    {
        $savingObject = Saving::where('id',$request->saving_id)->first();
        //$amount_withdrawn = str_replace(",", "", $request->withdrawn_amount);
       // $updated_balance = $savingObject->balance - $amount_withdrawn;
        $userObject = DB::table('users')->select('email','name')->where('id', $savingObject->user_id)->first();

       $withdrawal_details = [
            'applicant_name' => $userObject->name,
            'user_email' => $userObject->email,
            'reason_for_rejection'  => $request->reason_for_rejection,
            'description' => $savingObject->description,
            'amount_withdrawn' => $savingObject->amount_withdrawn,
            'balance' => $savingObject->balance,
        ];

        $chairApproveWithdrawal =  Saving::where('id',$request->saving_id)->update([
            'chair_approve' => $request->chair_approve,
            'status' => 'Approved',
        ]);

        $updateApplication = Application::where('user_id',$savingObject->user_id)->update([
            'status' => 'Approved',
        ]);

        //notify the applicant of loan approval
        (new MailController())->savingsWithdrawalApprovalNotifyMember($withdrawal_details);

        if($chairApproveWithdrawal && $updateApplication){
            $data = ['success' => true, 'message'=> "Withdrawal Approved by President"];
            return response()->json($data);
        }

    }

    private function rejectSavingsWithdrawal(Request $request)
    {
        $cur_balance = Saving::where('id',$request->saving_id)->first()->balance;
        $withdrawn_amount = str_replace(",", "", $request->withdrawn_amount);
        $updated_balance = $withdrawn_amount + $cur_balance;
        //$rejectedBy = Auth::user()->user_role;

        $rejectSavingWithdrawal =  Saving::where('id',$request->saving_id)->update([
            'status' => 'Rejected',
            'sec_approve' => '(NULL)',
            'chair_approve' => '(NULL)',
            'reason_for_rejection' => $request->reason_for_rejection,
            'balance' => $updated_balance,
            'amount_withdrawn' => $withdrawn_amount,
        ]);

        //notify the applicant of application rejection
        $savingUserID = Saving::where('id',$request->saving_id)->first()->user_id;
        $userObject = DB::table('users')->select('email','name')->where('id', $savingUserID)->first();

        $rejection_details = [
            'applicant_name' => $userObject->name,
            'email' => $userObject->email,
            'reason_for_rejection'  => $request->reason_for_rejection,
        ];

        (new MailController)->loanApplicationRejectionNotification($rejection_details);

        if($rejectSavingWithdrawal){
            $data = ['success' => true, 'message'=> "Withdrawal Request Rejected"];
            return response()->json($data);
        }

    }

    private function revokeSavingWithdrawal(Request $request)
    {
        $cur_balance = Saving::where('id',$request->saving_id)->first()->balance;
        $withdrawn_amount = str_replace(",", "", $request->withdrawn_amount);
        $updated_balance =  $cur_balance - $withdrawn_amount;

        $revokeWithdrawal =  Saving::where('id',$request->saving_id)->update([
            'status' => 'Processing',
            'balance' => $updated_balance,
            'reason_for_rejection'  => '',
        ]);
        if($revokeWithdrawal){
            $data = ['success' => true, 'message'=> "Withdrawal Request Set to Draft"];
            return response()->json($data);
        }

    }



}
