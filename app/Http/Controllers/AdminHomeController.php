<?php

namespace App\Http\Controllers;

use App\Appropriation;
use App\Expense;
use App\Income;
use App\Installment;
use App\LoanProduct;
use App\Loan;
use App\Saving;
use App\Transaction;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminHomeController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function showAdminHome()
    {
        $currentMonth = date('Y');
        //Get total loan value
        $total_loan_value = Loan::sum('loan_amount');
        //get total loan recovered
        $total_loan_recovered = Loan::sum('amount_recovered');

        //get total saving
        $total_saving_value = Saving::where('month','LIKE','%'.$currentMonth.'%')->sum('amount_saved');

        //get total debits
        $total_debits = Saving::where('month','LIKE','%'.$currentMonth.'%')->sum('amount_withdrawn');

        //get total transaction
        $total_transaction = Transaction::sum('transaction_amount');

        $total_income = Income::sum('income_realized');

        $total_expense = Expense::sum('total_price');

        //get all loan products
        $products = LoanProduct::all()->toArray();
        //get total members
        $members = User::where([['membership_status','=',true],['is_verified','=',true],['deleted_at','=',null]])->get();

        //get all user transactions
        $transactions = Transaction:: all()->take(5);

        //get all loans
        $loans = Loan::all()->take(5);

        //proposed dividend
        $proposedDividend = Appropriation::where('created_at','LIKE','%'.date('Y').'%')->value('proposed_dividend');

        $dashboard_data = array(
            'total_loan_value' => $total_loan_value,
            'total_saving' => $total_saving_value,
            'products' => $products,
            'total_transaction' => $total_transaction,
            'total_income' => $total_income,
            'total_debits' => $total_debits,
            'total_loan_recovered' => $total_loan_recovered,
            'members' => $members,
            'total_expense' => $total_expense,
            'proposedDividend' => $proposedDividend
        );
        return view('dashboard.admin.adminHome',compact('dashboard_data','transactions','loans'));
    }


}
