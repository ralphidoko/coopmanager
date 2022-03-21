<?php

namespace App\Http\Controllers;

use App\LoanProduct;
use App\Loan;
use App\Member;
use App\Notifications\AccountActivated;
use App\Saving;
use App\Transaction;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    public function renderHomeDashboard()
    {
         $checkUserVerificationStatus = Member::where('user_id',Auth::id())->first();

         if ($checkUserVerificationStatus->approval_count == 0 && $checkUserVerificationStatus->certification == 0 ) {

             return redirect('/UpdateUserProfile');

         } elseif ($checkUserVerificationStatus->approval_count == 1 && $checkUserVerificationStatus->certification == 0) {

             return redirect('/UpdateUserProfile');

         } elseif ($checkUserVerificationStatus->approval_count == 2 && $checkUserVerificationStatus->certification == 0) {

             return redirect('/UpdateUserProfile');

         } elseif ($checkUserVerificationStatus->approval_count == 1 || $checkUserVerificationStatus->approval_count == 2 || $checkUserVerificationStatus->approval_count == 0 && $checkUserVerificationStatus->certification == 1) {

             //Get total loan value
             $total_loan_value = Loan::where('user_id', Auth::id())->sum('loan_amount');

             //get total saving
             $total_saving_value = Saving::where('user_id', Auth::id())->sum('amount_saved');

             $total_withdrawals = Saving::where('user_id', Auth::id())->where('status', 'Approved')->sum('amount_withdrawn');

             //get all user transactions
             $transactions = Transaction::where('user_id', Auth::user()->id)->orderByDESC('id')->limit(5)->get();

             //get all user loans
             $loans = Loan::where('user_id', Auth::id())->limit(5)->get();

             //get all savings
             $savings = Saving::where('user_id', Auth::id())->limit(4)->orderBy('id', 'desc')->get();

             //get total transaction
             $total_transactions = Transaction::where('user_id', Auth::id())->sum('transaction_amount');

             //get all loan products
             $products = LoanProduct::all()->toArray();

             $dashboard_data = array(
                 'total_loan_value' => $total_loan_value,
                 'total_saving' => $total_saving_value,
                 'products' => $products,
                 'total_transactions' => $total_transactions,
                 'total_withdrawals' => $total_withdrawals,
             );
             \App\Helpers\LogActivity::logUserActivity(' User Logged in into Dashboard');
             return view('dashboard.resident', compact('transactions', 'loans', 'savings'), ['dashboard_data' => $dashboard_data]);

         }

    }


}
