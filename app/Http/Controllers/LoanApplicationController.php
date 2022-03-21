<?php

namespace App\Http\Controllers;

use App\Application;
use App\Events\UpdateApplicationStatusEvent;
use App\Installment;
use App\LoanProduct;
use App\Loan;
use App\LogActivity;
use App\Member;
use App\Saving;
use App\User;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class LoanApplicationController extends Controller
{

    public function checkApplicationStatus()
    {
        $checkExistingLoanApplication = DB::Table('applications')->where('user_id',Auth::id())->first();
        $checkExistingSaving = DB::Table('savings')->where('user_id',Auth::id())->first();
        $multipleLoanPermissionCount = Member::where('user_id',Auth::id())->first();

        if($checkExistingSaving != null):
            if(!empty($checkExistingLoanApplication)):
                if($checkExistingLoanApplication->user_id  && $checkExistingLoanApplication->status == 'Approved' && $multipleLoanPermissionCount->multiple_loan_permission == 0):
                    return redirect()->back()->with('warning','Members are not allowed to have two concurrent loan applications.');
                elseif ($checkExistingLoanApplication->user_id && $checkExistingLoanApplication->status == 'Processing' && $multipleLoanPermissionCount->multiple_loan_permission == 0):
                    return redirect()->back()->with('warning','Your current application is still awaiting approval.');
                elseif($checkExistingLoanApplication->user_id  && $checkExistingLoanApplication->status == 'Approved' && $multipleLoanPermissionCount->multiple_loan_permission == 1):
                    return redirect('/accountActivation/makePayment');
                else:
                    return $this->renderApplicationForm();
                endif;
           else:
               return redirect('/accountActivation/makePayment');
           endif;
        else:
            return redirect()->back()->with('warning',"You don't have any savings yet. Please make some deposits before applying for loan");
        endif;
    }

    private function renderApplicationForm()
    {
        if(isset($_SERVER['HTTP_REFERER'])):
            return view('dashboard.application.loanApplication');
        else:
            return redirect('/dashboard/home');
        endif;
    }

    public function showAvailableLoan()
    {
        $loans = DB::table('loans')->where('user_id',Auth::id())->get();
        \App\Helpers\LogActivity::logUserActivity('User Viewed Loans');
        return view('dashboard.application.loanList',['loans'=>$loans]);
    }

    public function viewLoanDetailAndInstallments(Request $request)
    {
        //get total installment paid
        $total_amount_payable = Installment::where('loan_id',$request->loan_id)->sum('monthly_installment');
        $total_installment_paid = Installment::where('loan_id',$request->loan_id)->where('status','Paid')->sum('monthly_installment');
        $total_unpaid_instalment = Installment::where('loan_id',$request->loan_id)->where('status','Unpaid')->sum('monthly_installment');
        $loan_bal = $total_unpaid_instalment;
        $loan = Loan::where('id',$request->loan_id)->firstOrFail();
        return view('dashboard.application.loanDetails',compact('loan','total_installment_paid','loan_bal','total_amount_payable'));
    }

    public function showLoanDetail($loan_id)
    {
        $loan = Loan::where('id',$loan_id)->firstOrFail();
        return view('dashboard.application.updateLoan',['loan'=>$loan]);
    }

    //Helper function calculating payment schedule
    private function addMonths($months, DateTime $dateObject)
    {
        $next = new DateTime($dateObject->format('Y-m-d'));
        $next->modify('last day of +'.$months.' month');

        if($dateObject->format('d') > $next->format('d')) {
            return $dateObject->diff($next);
        } else {
            return new DateInterval('P'.$months.'M');
        }
    }

    private function calculatePaymentSchedule($d1, $months)
    {
        $date = new DateTime($d1);

        // call second function to add the months
        $newDate = $date->add($this->addMonths($months, $date));

        // goes back 1 day from date, remove if you want same day of month
        // $newDate->sub(new DateInterval('P1D'));

        //formats final date to Y-m-d form
        $dateReturned = $newDate->format('Y-m-d');

        return $dateReturned;
    }

    public function getItemPrice(Request $request)
    {
          $item_price = LoanProduct::where('id',$request->item_id)->first()->item_price;
          $item_price = number_format($item_price,2);
          $data = ['success' => true, 'item_price'=> $item_price];
          return response()->json($data);
    }

    public function deleteLoanApplication(Request $request)
    {
        if(Auth::check()){
            Loan::find($request->loan_id)->delete();
            Installment::where([
                ['loan_id','=',$request->loan_id], ['status','=','Unpaid']
            ])->delete();
            Application::where('user_id',Auth::id())->delete();
            \App\Helpers\LogActivity::logUserActivity('User Deleted Loan Application');
            session()->flash('success','Your application has been deleted. You may wish to reapply!');
            return response()->json(['url'=>url('/application/loanList')]);
        }else{
            Auth::logout();
        }

    }

    private function updateCashLoan(Request $request)
    {
        //check total saving
        $total_savings = Saving::latest()->where('user_id',Auth::id())->first()->balance;
        $three_perc_of_account_balance = $total_savings * 3;

        //get guarantor's name
        $guarantor_one = User::where('phone_no', $request->guarantor_one)->pluck('name');
        $guarantor_two = User::where('phone_no', $request->guarantor_two)->pluck('name');

        //check if guarantor exists
        $gone = DB::table('loans')->where('g1_phone_no', $request->guarantor_one)->exists();
        $gtwo = DB::table('loans')->where('g2_phone_no', $request->guarantor_two)->exists();

        $cash_loan_amount = str_replace(",", "", $request->cash_loan_amount);

        if($cash_loan_amount > $three_perc_of_account_balance):
            $data = ['success' => true, 'message'=> 'Sorry, you cannot apply more than '.number_format($three_perc_of_account_balance,2).', try reducing loan amount'];
            return response()->json($data);
        elseif($guarantor_one[0] == $guarantor_two[0]):
            $data = ['success' => true, 'message'=> "You can't select the same guarantor, guarantors must be different."];
            return response()->json($data);
//        elseif($gone == true):
//            $data = ['success' => true, 'message'=> "guarantor one already exist; can't guarantee two loans at the same time"];
//            return response()->json($data);
//        elseif($gtwo == true):
//            $data = ['success' => true, 'message'=> "guarantor two already exist; can't guarantee two loans at the same time"];
//            return response()->json($data);
        else:
            //proceed to compute loan
            $cash_loan_rate = 7/100;
            $cash_loan_tenor = 24;
            $total_interest_payable = $cash_loan_amount * $cash_loan_rate;
            $total_pay_back = $total_interest_payable + $cash_loan_amount;
            $monthly_interest_payable = $total_pay_back/$cash_loan_tenor;
            $loan_repayment_start_date =  date('Y-m-d',strtotime('last day of +1 month'));

            //create loan details
            Loan::where('id',$request->loan_id)->update([
                'loan_amount' => $cash_loan_amount,
                'total_amount_payable' => $total_pay_back,
                'total_interest_payable' => $total_interest_payable,
                'monthly_interest_payable' => $monthly_interest_payable,
                'loan_type' => 'Cash Loan',
                'cash_loan_rate' => $cash_loan_rate,
                'no_of_installments' => $cash_loan_tenor,
                'cash_loan_tenor' => $cash_loan_tenor,
                'status' => 'Processing',
                'guarantor_one' =>$guarantor_one[0],
                'guarantor_two' =>$guarantor_two[0],
                'g1_phone_no' => $request->guarantor_one,
                'g2_phone_no' => $request->guarantor_two,
            ]);

            $date_array = [];
            for($i = 0; $i < $cash_loan_tenor; $i++){
                global $final;
                $final = $this->calculatePaymentSchedule($loan_repayment_start_date, $i);
                array_push($date_array,$final);
            }

           //cleanup previous installments
             Installment::where([['loan_id','=',$request->loan_id], ['status','=','Unpaid']])->delete();

            //update loan installments
            $amount_payable = $total_pay_back;
            $current_bal = $amount_payable;
            for($i =0; $i < count($date_array); $i++) {
                $current_bal = $current_bal - $monthly_interest_payable;
                $payment_date = $date_array[$i];
                Installment::create([
                    'loan_id' => $request->loan_id,
                    'unique_id' => Str::random(9),
                    'monthly_installment' => $monthly_interest_payable,
                    'status' => 'Unpaid',
                    'payment_date' => $payment_date,
                    'current_balance' => $current_bal,
                ]);

            }
            \App\Helpers\LogActivity::logUserActivity(' User Updated Loan Application');
            session()->flash('success',"Your application has been updated and it's being processed!");
            return response()->json(['url'=>url('/application/loanList')]);
        endif;
    }

    private function updateEquipmentLoan(Request $request)
    {
        //check total saving
        $total_savings = Saving::latest()->where('user_id',Auth::id())->first()->balance;
        $three_perc_of_account_balance = $total_savings * 3;

        //get guarantor's name using phone no from user table
        $guarantor_one = User::where('phone_no', $request->guarantor_one)->pluck('name');
        $guarantor_two = User::where('phone_no', $request->guarantor_two)->pluck('name');

        //check if guarantor exists
        $gone = DB::table('loans')->where('g1_phone_no', $request->guarantor_one)->exists();
        $gtwo = DB::table('loans')->where('g2_phone_no', $request->guarantor_two)->exists();

        //get item price
        $item_details = DB::table('items')->where('id', $request->item_loan_name)->first();

        if($item_details->item_price > $three_perc_of_account_balance):
            $data = ['success' => true, 'message'=> 'Sorry, you cannot apply more than '.number_format($three_perc_of_account_balance,2).', try reducing loan amount'];
            return response()->json($data);
        elseif($guarantor_one[0] == $guarantor_two[0]):
            $data = ['success' => true, 'message'=> "You can't select the same guarantor, guarantors must be different."];
            return response()->json($data);
//        elseif($gone == true):
//            $data = ['success' => true, 'message'=> "guarantor one already exist; can't guarantee two loans at the same time"];
//            return response()->json($data);
//        elseif($gtwo == true):
//            $data = ['success' => true, 'message'=> "guarantor two already exist; can't guarantee two loans at the same time"];
//            return response()->json($data);
        else:
            //proceed to compute loan
            $item_loan_rate = 3/100;
            $item_loan_tenor = 6;
            $total_interest_payable = $item_details->item_price * $item_loan_rate;
            $total_pay_back = $total_interest_payable + $item_details->item_price;
            $monthly_interest_payable = $total_pay_back/$item_loan_tenor;
            $loan_repayment_start_date =  date('Y-m-d',strtotime('last day of +1 month'));

            //create loan details
            Loan::where('id',$request->loan_id)->update([
                'loan_amount' => $item_details->item_price,
                'total_amount_payable' => $total_pay_back,
                'total_interest_payable' => $total_interest_payable,
                'monthly_interest_payable' => $monthly_interest_payable,
                'loan_type' => 'Household Equipment Loan',
                'item_name' => $item_details->item_name,
                'item_price' => $item_details->item_price,
                'item_loan_rate' => $item_loan_rate,
                'no_of_installments' => $item_loan_tenor,
                'item_loan_tenor' => $item_loan_tenor,
                'status' => 'Processing',
                'guarantor_one' =>$guarantor_one[0],
                'guarantor_two' =>$guarantor_two[0],
                'g1_phone_no' => $request->guarantor_one,
                'g2_phone_no' => $request->guarantor_two,
            ]);

            $date_array = [];
            for($i = 0; $i < $request->item_loan_tenor; $i++){
                global $final;
                $final = $this->calculatePaymentSchedule($loan_repayment_start_date, $i);
                array_push($date_array,$final);
            }

            //cleanup payment schedule
            Installment::where([['loan_id','=',$request->loan_id], ['status','=','Unpaid']])->delete();

            //update loan installments
            $amount_payable = $total_pay_back;
            $current_bal = $amount_payable;
            for($i =0; $i < count($date_array); $i++) {
                $current_bal = $current_bal-$monthly_interest_payable;
                $payment_date = $date_array[$i];
                Installment::create([
                    'loan_id' => $request->loan_id,
                    'unique_id' => Str::random(9),
                    'monthly_installment' => $monthly_interest_payable,
                    'status' => 'Unpaid',
                    'payment_date' => $payment_date,
                    'current_balance' => $current_bal,
                ]);

            }
            \App\Helpers\LogActivity::logUserActivity(' User Updated Loan Application');
            session()->flash('success',"Your application has been updated and it's being processed!");
            return response()->json(['url'=>url('/application/loanList')]);
        endif;
    }

    public function updateLoan(Request $request)
    {
        if(Auth::check()){
            if($request->loan_type != null):
                if($request->loan_type == 1):
                    $validator = request()->validate([
                        'applicant' => 'required',
                        'cash_loan_amount' => 'required',
                        'guarantor_one' => 'required',
                        'guarantor_two' => 'required',
                    ]);
                    if(!in_array('message',$validator)){
                            return $this->updateCashLoan($request);
                        }else {
                        return response()->json();
                    }
                elseif($request->loan_type == 2):
                    $validator = request()->validate([
                        'applicant' => 'required',
                        'item_loan_name' => 'required',
                        'item_loan_amount' => 'required',
                        'guarantor_one' => 'required',
                        'guarantor_two' => 'required',
                    ]);
                    if(!in_array('message',$validator)){
                        return $this->updateEquipmentLoan($request);
                    }else {
                        return response()->json();
                    }
                endif;
            endif;
        }
    }

    public function payOutStandingLoanBalance(Request $request)
    {
        $unpaid_installments = Installment::where('loan_id',$request->loan_id)->where('status','Unpaid')->sum('monthly_installment');
        $loan_id = $request->loan_id;
        return view('dashboard.accountActivation.offSetLoanBalance',compact('unpaid_installments','loan_id'));

    }


}
