<?php

namespace App\Http\Controllers;

use App\Saving;
use App\Transaction;
use App\User;
use Illuminate\Http\Request;

class AdminMemberTransactionController extends Controller
{
    public function showMembersTransactions()
    {
        $user_ids = Transaction::all()->pluck('user_id');
        $users = User::with('transactions')->whereIn('id',$user_ids)->paginate(20);
            $totalTransaction = Transaction::sum('transaction_amount');
        return view('dashboard.admin.membersTransactions',compact('users','totalTransaction'));
    }
}
