<?php

namespace App\Http\Livewire;

use App\Application;
use App\Events\LoanApplicationSubmissionMailEvent;
use App\Events\UpdateApplicationStatusEvent;
use App\Installment;
use App\LoanProduct;
use App\Loan;
use App\Mail\LoanApplicationSubmitted;
use App\Saving;
use App\User;
use DateInterval;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;
use Illuminate\Support\Facades\Mail;


class LoanApplication extends Component
{
    public $applicant,$loan_type,$cash_loan_amount,$cash_loan_rate=7,$cash_loan_tenor=24,$item_name,$item_price,$item_rate=3,
           $item_loan_tenor=6,$guarantor_one,$guarantor_two,$g1_phone_no,$g2_phone_no;

    public $users,$items,$savings;

    public function mount()
    {
        $this->users = User::where('id', '!=', auth()->id())->get();
        $users = $this->users;
        $this->items = LoanProduct::all();
        $items = $this->items;
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

    //real-time validation
//    public function updated($field)
//    {
//        //$this->validateOnly($field, ['applicant'=>'required']);
//        $this->validateOnly($field, ['loan_type'=>'required']);
//        $this->validateOnly($field, ['guarantor_one'=>'required']);
//        $this->validateOnly($field, ['cash_loan_amount'=>'required']);
//        $this->validateOnly($field, ['item_name'=>'required']);
//        $this->validateOnly($field, ['guarantor_two'=>'required']);
//
//    }

    public function submitLoanApplication()//edit validation
    {
       // $this->validate(['applicant'=>'required']);
        //$this->validate(['loan_type'=>'required']);
        //$this->validate(['guarantor_one'=>'required']);
        //$this->validate(['guarantor_two'=>'required']);


        //determine loan type
        if ($this->loan_type == 1) {
            //$this->validate(['cash_loan_amount'=>'required']);

            return $this->handleCashLoan();

        } elseif ($this->loan_type == 2) {
            //$this->validate(['item_name'=>'required']);

            return $this->handleEquipmentLoan();

        }else{
            return redirect()->back()->with('warning','Application type does not exist');
        }

    }

    private function handleCashLoan()
    {
        $cash_loan_amount = str_replace(",", "", $this->cash_loan_amount);
        $cash_loan_rate=$this->cash_loan_rate;$cash_loan_tenor=$this->cash_loan_tenor;
        $guarantor_one=$this->guarantor_one;$guarantor_two=$this->guarantor_two;$g1_phone_no=$this->guarantor_one;
        $g2_phone_no=$this->guarantor_two;

        //check total savings
        $total_savings = Saving::latest()->where('user_id',Auth::id())->first()->balance;
        $three_perc_of_account_balance = $total_savings * 3;

        //get guarantor's name
        $guarantor_one = User::where('phone_no', $guarantor_one)->pluck('name');
        $guarantor_two = User::where('phone_no', $guarantor_two)->pluck('name');

        //check if guarantor exists
        $gone = DB::table('loans')->where('g1_phone_no', $g1_phone_no)->exists();
        $gtwo = DB::table('loans')->where('g2_phone_no', $g2_phone_no)->exists();

        if($cash_loan_amount > $three_perc_of_account_balance):
            session()->flash('message','Sorry, you cannot apply more than '.number_format($three_perc_of_account_balance,2).', try reducing loan amount');
        elseif($guarantor_one == $guarantor_two):
                session()->flash('message',"You can't select the same guarantor, guarantors must be different.");
//        elseif($gone == true):
//                session()->flash('message',"guarantor one already exist; can't guarantee two loans at the same time");
//        elseif($gtwo == true):
//            session()->flash('message',"guarantor two already exist; can't guarantee two loans at the same time");
        else:
            //proceed to compute loan
            $total_interest_payable = $cash_loan_amount * ($cash_loan_rate/100);
            $total_pay_back = $total_interest_payable + $cash_loan_amount;
            $monthly_interest_payable = $total_pay_back/$cash_loan_tenor;
            $loan_repayment_start_date =  date('Y-m-d',strtotime('last day of +1 month'));


            //create loan details
            $loanDetails = Loan::create([
                'user_id' => Auth::id(),
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
                'g1_phone_no' => $g1_phone_no,
                'g2_phone_no' => $g2_phone_no,

            ]);

            $date_array = [];

            for($i = 0; $i < $cash_loan_tenor; $i++){
                global $final;
                $final = $this->calculatePaymentSchedule($loan_repayment_start_date, $i);
                array_push($date_array,$final);
            }

            //create loan installments
            $amount_payable = $total_pay_back;
            $current_bal = $amount_payable;
            for($i =0; $i < count($date_array); $i++) {
                $current_bal = $current_bal-$monthly_interest_payable;
                $payment_date = $date_array[$i];
                Installment::create([
                    'loan_id' => $loanDetails->id,
                    'unique_id' => Str::random(9),
                    'monthly_installment' => $monthly_interest_payable,
                    'status' => 'Unpaid',
                    'payment_date' => $payment_date,
                    'current_balance' => $current_bal,
                ]);

            }

            event(new UpdateApplicationStatusEvent($loanDetails));

            //loan application notification()
            $user_name = User::where('id',Auth::id())->firstOrFail()->name;
            $user_email = User::where('id',Auth::id())->firstOrFail()->email;
            $admin_email = User::where('is_admin',true)->pluck('email')->all();//collect emails of all admin users

            $loan_details = [
                'user_email' => $user_email,
                'user_name' => $user_name,
                'admin_email' => $admin_email,
                'loan_amount' => $cash_loan_amount,
                'loan_type' => 'Cash Loan',
                'cash_loan_rate' => $cash_loan_rate,
                'cash_loan_tenor' => $cash_loan_tenor,
                ];

            event(new LoanApplicationSubmissionMailEvent($loan_details));
            \App\Helpers\LogActivity::logUserActivity(' User Submitted Cash Loan');
            session()->flash('success',"Your application has been submitted and it's being processed!");

            redirect()->to('/application/loanList');
        endif;
    }

    private function handleEquipmentLoan()
    {
        $item_name=$this->item_name;$item_price=$this->item_price;$item_rate=$this->item_rate;$item_loan_tenor=$this->item_loan_tenor;
        $guarantor_one=$this->guarantor_one;$guarantor_two=$this->guarantor_two;$g1_phone_no=$this->g1_phone_no;$g2_phone_no=$this->g2_phone_no;

        //check total saving
        $total_savings = Saving::latest()->where('user_id',Auth::id())->first()->balance;
        $three_perc_of_account_balance = $total_savings * 3;

        //get guarantor's name
        $guarantor_1 = DB::table('users')->where('phone_no', $guarantor_one)->first();
        $guarantor_2 = DB::table('users')->where('phone_no', $guarantor_two)->first();

        //check if guarantor exists
        $gone = DB::table('loans')->where('g1_phone_no', $g1_phone_no)->exists();
        $gtwo = DB::table('loans')->where('g2_phone_no', $g2_phone_no)->exists();

        //get item price
        $item_details = DB::table('items')->where('id', $item_name)->first();

        if($item_details->item_price > $three_perc_of_account_balance):
            session()->flash('message','Sorry, you cannot apply more than '.number_format($three_perc_of_account_balance,2).', try reducing loan amount');
        elseif($guarantor_one == $guarantor_two):
            session()->flash('message',"You can't select the same guarantor, guarantors must be different.");
//        elseif($gone == true):
//            session()->flash('message',"guarantor one already exist; can't guarantee two loans at the same time");
//        elseif($gtwo == true):
//            session()->flash('message',"guarantor two already exist; can't guarantee two loans at the same time");
        else:
            //proceed to compute loan
            $total_interest_payable = $item_details->item_price * ($item_rate/100);
            $total_pay_back = $total_interest_payable + $item_details->item_price;
            $monthly_interest_payable = $total_pay_back/$item_loan_tenor;
            $loan_repayment_start_date =  date('Y-m-d',strtotime('last day of +1 month'));

            //create loan details
            $loanDetails = Loan::create([
                'user_id' => Auth::id(),
                'loan_amount' => $item_details->item_price,
                'total_amount_payable' => $total_pay_back,
                'total_interest_payable' => $total_interest_payable,
                'monthly_interest_payable' => $monthly_interest_payable,
                'loan_type' => 'Household Equipment Loan',
                'item_name' => $item_details->item_name,
                'item_price' => $item_details->item_price,
                'item_loan_rate' => $item_rate,
                'no_of_installments' => $item_loan_tenor,
                'item_loan_tenor' => $item_loan_tenor,
                'status' => 'Processing',
                'guarantor_one' =>$guarantor_1->name,
                'guarantor_two' =>$guarantor_2->name,
                'g1_phone_no' => $guarantor_1->phone_no,
                'g2_phone_no' => $guarantor_2->phone_no,
            ]);

            $date_array = [];

            for($i = 0; $i < $item_loan_tenor; $i++){
                global $final;
                $final = $this->calculatePaymentSchedule($loan_repayment_start_date, $i);
                array_push($date_array,$final);
            }

            //$loan_id = Loan::where('user_id',Auth::id())->firstOrFail()->id;

            //create loan installments
            $amount_payable = $total_pay_back;
            $current_bal = $amount_payable;
            for($i =0; $i < count($date_array); $i++) {
                $current_bal = $current_bal-$monthly_interest_payable;
                $payment_date = $date_array[$i];
                Installment::create([
                    'loan_id' => $loanDetails->id,
                    'unique_id' => Str::random(9),
                    'monthly_installment' => $monthly_interest_payable,
                    'status' => 'Unpaid',
                    'payment_date' => $payment_date,
                    'current_balance' => $current_bal,
                ]);

            }
            //update application status
            event(new UpdateApplicationStatusEvent($loanDetails));

            //loan application notification(using event)
            $user_name = User::where('id',Auth::id())->firstOrFail()->name;
            $user_email = User::where('id',Auth::id())->firstOrFail()->email;
            $admin_email = User::where('is_admin',true)->pluck('email')->all();//collect emails of all admin users

            $loan_details = [
                'user_email' => $user_email,
                'user_name' => $user_name,
                'admin_email' => $admin_email,
                'loan_amount' => $item_details->item_price,
                'loan_type' => 'Household Equipment Loan',
                'cash_loan_rate' => $item_rate,
                'cash_loan_tenor' => $item_loan_tenor,
            ];

            event(new LoanApplicationSubmissionMailEvent($loan_details));
            \App\Helpers\LogActivity::logUserActivity(' User Submitted Product Loan');
            session()->flash('success',"Your application has been submitted and it's being processed!");
            redirect()->to('/application/loanList');

        endif;
    }

    public function render()
    {
        return view('livewire.loan-application');
    }







}
