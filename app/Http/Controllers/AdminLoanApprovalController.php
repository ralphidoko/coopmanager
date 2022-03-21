<?php

namespace App\Http\Controllers;

use App\Application;
use App\ChartOfAccount;
use App\GeneralLedger;
use App\Income;
use App\Installment;
use App\Journal;
use App\Loan;
use App\Member;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminLoanApprovalController extends Controller
{
    //
    public function showLoanApplicationList()
    {
        //get all loans
        $loans = Loan::all();
        return view('dashboard.admin.loanApplicationList',compact('loans'));
    }

    public function showLoanDetails(Request $request)
    {
        //get total installment paid
        $total_installment_paid = Installment::where('loan_id',$request->id)->where('status','Paid')->sum('monthly_installment');
        // $loan = Loan::where('id',$request->id)->firstOrFail();
        $loan = DB::table('loans')->join('members','members.user_id','=','loans.user_id')->join('users','users.id','=','loans.user_id')
            ->select('loans.*','members.designation','members.department','members.staff_no','users.passport_url','users.name','users.ippis_no','users.phone_no','users.member_id')
            ->where('loans.id',$request->id)->get();
        $installments = Installment::where('loan_id',$request->id)->get();
        return view('dashboard.admin.adminLoanApproval',compact('loan','total_installment_paid','installments'));
    }


    public function approveLoan(Request $request)
    {
        if($request->sec_approve){
            return $this->secApproveLoan($request);
        }elseif ($request->chair_approve){
            return $this->chairApproveLoan($request);
        }elseif ($request->reject_loan){
            return $this->rejectLoanApplication($request);
        }else{
            return $this->revokeLoanApproval($request);
        }
    }

    private function secApproveLoan(Request $request)
    {
       $secApproveLoan =  Loan::where('id',$request->loan_id)->update([
            'sec_approve' => $request->sec_approve,
         ]);
       if($secApproveLoan){
           $data = ['success' => true, 'message'=> "Application Approved by Secretary"];
           return response()->json($data);
       }
    }

    private function chairApproveLoan(Request $request)
    {
        $loanObject = Loan::where('id',$request->loan_id)->first();
        $applicantObject = DB::table('users')->select('email','name')->where('id', $loanObject->user_id)->first();

        $approval_details = [
            'applicant_name' => $applicantObject->name,
            'email' => $applicantObject->email,
            'reason_for_rejection'  => $request->reason_for_rejection,
            'loan_type' => $loanObject->loan_type,
            'loan_amount' => $loanObject->loan_amount,
            'cash_loan_tenor' => $loanObject->cash_loan_tenor,
            'cash_loan_rate' => $loanObject->cash_loan_rate,
        ];

        $updateApplicationTable =  Application::where('user_id',$loanObject->user_id)->update([
            'status' => 'Approved',
        ]);

        $resetMultipleLoanPermission = Member::where('user_id',$loanObject->user_id)->update([
            'multiple_loan_permission' => 0,
        ]);

        $loanCount = Loan::where('status','Approved')->orWhere('status','Settled')->count();
        $loanCount = sprintf('LOAN/'.date('Y')."/%'.05d",$loanCount+1);
        $coopAccountID = Journal::where('name','Cooperative Loan')->first()->id;
        $charOfAccountID = ChartOfAccount::where('name','Cooperative Loan Account')->first()->id;
        $cumulativeBalance = GeneralLedger::orderBy('id','desc')->first();

        $_cumulativeBalance =  ($cumulativeBalance != null) ?
            $cumulativeBalance->cumulative_balance +  $loanObject->loan_amount :
            $loanObject->loan_amount;

        GeneralLedger::create([
            'journal_id' => $coopAccountID,
            'coa_id' => $charOfAccountID,
            'vendor' => 'Nepza Cooperative',
            'reference' => 'Loan Disbursed',
            'move' => $loanCount,
            'debit' => $loanObject->loan_amount,
            'cumulative_balance' => $_cumulativeBalance,
        ]);
        $chairApproveLoan =  Loan::where('id',$request->loan_id)->update([
            'chair_approve' => $request->chair_approve,
            'status' => 'Approved',
        ]);

        //notify the applicant of loan approval
        (new MailController)->loanApplicationApprovalNotification($approval_details);

        if($updateApplicationTable && $chairApproveLoan && $resetMultipleLoanPermission){
            $data = ['success' => true, 'message'=> "Application Approved by President"];
            return response()->json($data);
        }

    }
    private function rejectLoanApplication(Request $request)
    {
        $rejectLoanApplication =  Loan::where('id',$request->loan_id)->update([
            'status' => 'Rejected',
            'sec_approve' => 'NULL',
            'chair_approve' => 'NULL',
            'reason_for_rejection' => $request->reason_for_rejection,
        ]);

        //notify the applicant of application rejection
        $loanApplicantID = Loan::where('id',$request->loan_id)->first()->user_id;
        $applicantEmail = User::where('id', $loanApplicantID)->first()->email;
        $applicantName = User::where('id', $loanApplicantID)->first()->name;

        $rejection_details = [
            'applicant_name' => $applicantName,
            'email' => $applicantEmail,
            'reason_for_rejection'  => $request->reason_for_rejection,
        ];

        (new MailController)->loanApplicationRejectionNotification($rejection_details);

        if($rejectLoanApplication){
            $data = ['success' => true, 'message'=> "Loan Application Rejected"];
            return response()->json($data);
        }

    }
    private function revokeLoanApproval(Request $request)
    {
        $rejectLoanApplication =  Loan::where('id',$request->loan_id)->update([
            'status' => 'Processing',
            'reason_for_rejection' => '',
        ]);
        if($rejectLoanApplication){
            $data = ['success' => true, 'message'=> "Loan Application Set to Draft"];
            return response()->json($data);
        }

    }
    public function grantApprovalForMultipleLoan(Request $request)
    {
        $checkExistingLoan = DB::Table('applications')->where('user_id',$request->user_id)->first();
        $permissionCount = Member::where('user_id',$request->user_id)->firstOrFail();
        $permissionCount = $permissionCount->permission_count + 1;

        if($checkExistingLoan){
            if($checkExistingLoan->status == 'Payment Confirmed' || $checkExistingLoan->status == 'Processing' && $permissionCount->multiple_loan_permission == 0):
                $data = ['warning' => true, 'message'=> "Previous loan is still awaiting approval"];
                return response()->json($data);
            elseif($checkExistingLoan->status == 'Approved' && $permissionCount <= 3):
                $grantPermission = member::where('user_id',$request->user_id)->update([
                    'multiple_loan_permission' => 1,
                    'permission_count' => $permissionCount,
                ]);
            else:
                $data = ['warning' => true, 'message' => "Maximum number of permissions  has been reached!"];
                return response()->json($data);
            endif;
            if($grantPermission) {
                $data = ['success' => true, 'message' => "Permission granted!"];
                return response()->json($data);
            }
        }else{
            $data = ['warning' => true, 'message'=> "Members must have an existing loan in order to be granted permission"];
            return response()->json($data);
        }

    }
}
