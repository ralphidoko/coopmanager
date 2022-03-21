<?php

namespace App\Http\Controllers;

use App\Saving;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function showUserTransaction()
    {
        $transactions = Transaction::where('user_id',Auth::id())->get();
        \App\Helpers\LogActivity::logUserActivity(' User Visited Transaction Page');
        return view('dashboard.transactions.myTransactions',compact('transactions'));
    }
}
