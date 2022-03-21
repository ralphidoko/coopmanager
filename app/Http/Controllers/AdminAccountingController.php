<?php

namespace App\Http\Controllers;

use App\AccountClassification;
use App\Appropriation;
use App\ChartOfAccount;
use App\Expense;
use App\GeneralLedger;
use App\Income;
use App\Journal;
use App\JournalType;
use App\Loan;
use App\Saving;
use App\User;
Use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminAccountingController extends Controller
{
    //
    public function displayAccountChartForm()
    {
        $types = AccountClassification::all();
        $accounts = ChartOfAccount::all();
        return view('dashboard.admin.accounting.createAccountChart',compact('types','accounts'));
    }

    public function displayReportTemplate()
    {
        $currentYear = date('Y');
        $previousYear = $currentYear - 1;

        //get the balance brought forward
        $balanceBroughtForward = Saving::where('month','LIKE','%'.$previousYear.'%')->sum('amount_saved');
        //monthly members' deposits
        $monthlySavings = DB::table('savings')->SELECT(DB::raw('description'),DB::raw("DATE_FORMAT(month, '%M-%Y') month_year"),DB::raw('MONTH(month) month'),DB::raw('SUM(amount_saved) amount_saved'))
            ->where([['month','LIKE','%'.$currentYear.'%'],['description','=','Monthly Savings']])
            ->Orwhere([['month','LIKE','%'.$currentYear.'%'],['description','=','Extra Savings']])
            ->groupBy(DB::raw('MONTH(month)'))->orderBy(DB::raw('MONTH(month)'))->get();
        $totalDeposit = 0;
        foreach ($monthlySavings as $monthlySaving){
            $totalDeposit = $totalDeposit + $monthlySaving->amount_saved;
        }
        //monthly members' drawings
        $monthlyDrawings = DB::table('savings')->SELECT(DB::raw('description'),DB::raw("DATE_FORMAT(month, '%M-%Y') month_year"),DB::raw('MONTH(month) month'),DB::raw('SUM(amount_withdrawn) amount_withdrawn'))
            ->where([['month','LIKE','%'.$currentYear.'%'],['description','=','Savings Withdrawal']])
            ->groupBy(DB::raw('MONTH(month)'))->orderBy(DB::raw('MONTH(month)'))->get();
        $totalDrawings = 0;
        foreach ($monthlyDrawings as $monthlyDrawing){
            $totalDrawings = $totalDrawings + $monthlyDrawing->amount_withdrawn;
        }
        //get the current loan fees
        $monthlyLoanFees = DB::table('incomes')->SELECT(DB::raw('income_type'),DB::raw("DATE_FORMAT(created_at, '%M-%Y') month_year"),DB::raw('SUM(income_realized) income_realized'))
            ->where([['created_at','LIKE','%'.$currentYear.'%'],['income_type','=','Loan Application Fees']])
            ->groupBy(DB::raw('MONTH(created_at)'))->orderBy(DB::raw('MONTH(created_at)'))->get();
        $totalLoanFees = 0;
        foreach ($monthlyLoanFees as $monthlyLoanFee){
            $totalLoanFees = $totalLoanFees + $monthlyLoanFee->income_realized;
        }
        //get the balance brought forward
        $LoanBalBroughtForward = Loan::where([['created_at','LIKE','%'.$previousYear.'%'],['status','=','Approved']])->sum('loan_amount');
        //get monthly approved loan
        $monthlyApprovedLoans = DB::table('loans')->SELECT(DB::raw("DATE_FORMAT(created_at, '%M-%Y') month_year"),DB::raw('SUM(loan_amount) loan_amount'))
            ->where([['created_at','LIKE','%'.$currentYear.'%'],['status','=','Approved']])
            ->groupBy(DB::raw('MONTH(created_at)'))->orderBy(DB::raw('MONTH(created_at)'))->get();
        $totalApprovedLoan = 0;
        foreach ($monthlyApprovedLoans as $monthlyApprovedLoan){
            $totalApprovedLoan = $totalApprovedLoan + $monthlyApprovedLoan->loan_amount;
        }

        //get monthly recovered loan
        $monthlyRecoveredLoans = DB::table('loans')->SELECT(DB::raw("DATE_FORMAT(created_at, '%M-%Y') month_year"),DB::raw('SUM(amount_recovered) amount_recovered'))
            ->where([['created_at','LIKE','%'.$currentYear.'%'],['status','!=','Awaiting Approval']])
            ->groupBy(DB::raw('MONTH(created_at)'))->orderBy(DB::raw('MONTH(created_at)'))->get();
        $totalRecoveredLoan = 0;
        foreach ($monthlyRecoveredLoans as $monthlyRecoveredLoan){
            $totalRecoveredLoan = $totalRecoveredLoan + $monthlyRecoveredLoan->amount_recovered;
        }
        //get monthly income with sources
        $monthlyIncomes = DB::table('incomes')->SELECT(DB::raw("DATE_FORMAT(created_at,'%Y-%m') recorded_on"),DB::raw("DATE_FORMAT(created_at, '%M-%Y') month_year"),DB::raw('SUM(income_realized) income_realized'))
            ->where([['created_at','LIKE','%'.$currentYear.'%']])
            ->groupBy(DB::raw('MONTH(created_at)'))->orderBy(DB::raw('MONTH(created_at)'))->get();
        $totalMonthlyIncome = 0;
        foreach ($monthlyIncomes as $monthlyIncome){
            $totalMonthlyIncome = $totalMonthlyIncome + $monthlyIncome->income_realized;
        }

        //get monthly expenses with sources
        $monthlyExpenses = DB::table('expenses')->SELECT(DB::raw("DATE_FORMAT(created_at,'%m') transactionMonth"),DB::raw("DATE_FORMAT(created_at, '%M-%Y') monthYear"),DB::raw('SUM(total_price) subTotal'))
            ->where([['created_at','LIKE','%'.$currentYear.'%']])
            ->groupBy(DB::raw('MONTH(created_at)'))->orderBy(DB::raw('MONTH(created_at)'))->get();
        $totalMonthlyExpenses = 0;
        foreach ($monthlyExpenses as $monthlyExpense){
            $totalMonthlyExpenses = $totalMonthlyExpenses + $monthlyExpense->subTotal;
        }
        //income grouping
        $incomeGroupings = DB::table('incomes')->SELECT(DB::raw("income_type"),DB::raw("DATE_FORMAT(created_at, '%M-%Y') month_year"),DB::raw('SUM(income_realized) income_realized'))
            ->where([['created_at','LIKE','%'.$currentYear.'%']])
            ->groupBy(DB::raw('income_type'))->get();
        $totalGroupedIncome = 0;
        foreach ($incomeGroupings as $incomeGrouping){
            $totalGroupedIncome = $totalGroupedIncome + $incomeGrouping->income_realized;
        }

        //yearly appropriation
        $yearlyAppropriations = Appropriation::all();
        $totalApprovedLoan = 0;$educationReserve = 0;$statutoryReserve = 0;$proposedDividends = 0; $generalReserve = 0;
        foreach($yearlyAppropriations as $yearlyAppropriation){
            $totalApprovedLoan = $totalApprovedLoan + $yearlyAppropriation->education_reserve + $yearlyAppropriation->statutory_reserve + $yearlyAppropriation->proposed_dividend + $yearlyAppropriation->general_reserve;
            $educationReserve = $educationReserve + $yearlyAppropriation->education_reserve;
            $statutoryReserve = $statutoryReserve + $yearlyAppropriation->statutory_reserve;
            $proposedDividends = $proposedDividends + $yearlyAppropriation->proposed_dividend;
            $generalReserve = $generalReserve + $yearlyAppropriation->general_reserve;

        }

        $reportData = [
            'monthlySavings' => $monthlySavings,
            'totalDeposit' => $totalDeposit,
            'balanceBroughtForward' => $balanceBroughtForward,
            'monthlyDrawings' => $monthlyDrawings,
            'totalDrawings' => $totalDrawings,
            'monthlyLoanFees' => $monthlyLoanFees,
            'totalLoanFees' => $totalLoanFees,
            'monthlyApprovedLoans' => $monthlyApprovedLoans,
            'totalApprovedLoan' => $totalApprovedLoan,
            'LoanBalBroughtForward' => $LoanBalBroughtForward,
            'monthlyRecoveredLoans' => $monthlyRecoveredLoans,
            'totalRecoveredLoan' => $totalRecoveredLoan,
            'monthlyIncomes' => $monthlyIncomes,
            'totalMonthlyIncome' => $totalMonthlyIncome,
            'incomeGroupings' => $incomeGroupings,
            'totalGroupedIncome' => $totalGroupedIncome,
            'monthlyExpenses' => $monthlyExpenses,
            'totalMonthlyExpenses' => $totalMonthlyExpenses,
            'yearlyAppropriations' => $yearlyAppropriations,
            'totalAppropriation' => $totalApprovedLoan,
            'educationReserve' => $educationReserve,
            'statutoryReserve' => $statutoryReserve,
            'proposedDividend' => $proposedDividends,
            'generalReserve' => $generalReserve
            ];

        return view('dashboard.admin.accounting.reportTemplate',compact('reportData'));
    }
     public function createAccountChart(Request $request)
     {
        $checkUniqueCode = ChartOfAccount::where('code',$request->code)->first();
        if($checkUniqueCode){
            $data = ['warning' => true, 'message'=> 'You cannot have duplicate accounts. Code already exists.'];
            return response()->json($data);
        }else{
            $createAccount = ChartOfAccount::create([
                'code' => $request->code,
                'name' => $request->name,
                'type_id' => $request->type,
               ]);
            if($createAccount){
                $data = ['success' => true, 'message'=> 'Account Successfully Created.'];
                return response()->json($data);
            }
        }

     }

     public function updateAccountChart(Request $request)
     {
         $createAccount = ChartOfAccount::where('id',$request->chartID)->update([
                'code' => $request->code,
                'name' => $request->name,
                'type_id' => $request->type,
               ]);
         if($createAccount){
                $data = ['success' => true, 'message'=> 'Account Updated Successfully.'];
                return response()->json($data);
         }

     }

     public function deleteAccountChart(Request $request)
     {
         $transactions = Expense::where('account_id',$request->accountID)->first();
         if($transactions){
             $data = ['danger' => true, 'message'=> 'Account cannot be deleted, transactions already posted on the account'];
             return response()->json($data);
         }else{
             $deleteAccount = DB::table('chart_of_accounts')->where('id',$request->accountID)->delete();
             if($deleteAccount){
                 $data = ['success' => true, 'message'=> 'Account Successfully deleted.'];
                 return response()->json($data);
             }

         }

     }

     public function createJournals(Request $request)
     {
         $checkUniqueCode = Journal::where('code',$request->code)->first();
         if($checkUniqueCode){
             $data = ['warning' => true, 'message'=> 'You cannot have duplicate journal. Code already exist.'];
             return response()->json($data);
         }else{
             if($request->allow_cancel == true){$request->allow_cancel = 1;}
             $createJournal = Journal::create([
                 'code' => $request->code,
                 'name' => $request->name,
                 'type_id' => $request->type,
                 'allow_cancellation_entries' => $request->allow_cancel,
             ]);
             if($createJournal){
                 $data = ['success' => true, 'message'=> 'Journal Successfully Created.'];
                 return response()->json($data);
             }
         }
     }

    public function updateJournal(Request $request)
    {

        if($request->allow_cancel == true){$request->allow_cancel = 1;}
        $updateJournal = Journal::where('id',$request->chartID)->update([
            'code' => $request->code,
            'name' => $request->name,
            'type_id' => $request->type,
            'allow_cancellation_entries' => $request->allow_cancel,
        ]);
        if($updateJournal){
            $data = ['success' => true, 'message'=> 'Journal Updated Successfully.'];
            return response()->json($data);
        }

    }

    public function deleteJournal(Request $request)
    {
        $transactions = GeneralLedger::where('journal_id',$request->accountID)->first();
        if($transactions){
            $data = ['warning' => true, 'message'=> 'You cannot delete journal with posted transactions.'];
            return response()->json($data);
        }else{
            $deleteJournal = DB::table('journals')->where('id',$request->accountID)->delete();
            if($deleteJournal){
                $data = ['success' => true, 'message'=> 'Journal Successfully deleted.'];
                return response()->json($data);
            }

        }

    }

    public function displayExpenseForm()
    {
        $accounts = ChartOfAccount::all();
        $paymentJournals = Journal::all();
        $expenses = Expense::withTrashed()->orderByDesc('id')->get();
        $totalExpense = Expense::sum('total_price');
        return view('dashboard.admin.accounting.recordExpense',compact('accounts','paymentJournals','expenses','totalExpense'));
    }

    public function displayJournalForm()
    {
        $journals = Journal::all();$types = JournalType::all();
        return view('dashboard.admin.accounting.createJournals',compact('journals','types'));
    }

    public function registerExpenses(Request $request)
    {
        //register expense
       $expenseCount = Expense::all()->count();
       $expenseCount = sprintf('EXP/'.date('Y')."/%'.05d",$expenseCount + 1);
       $registerExpense = Expense::create([
           'description' => $request->description,
           'account_id' => $request->coa,
           'unit_price' => $request->unit_price,
           'quantity' => $request->quantity,
           'total_price' => $request->sub_total,
           'vendor' => $request->vendor,
           'posted_by' => Auth::id(),
           'expense_number'=>$expenseCount,
           'product_service'=>$request->product,
           'status' => 'Posted'
       ]);
       //create journal entries
        $cumulativeBalance = GeneralLedger::orderBy('id','desc')->first();

        $_cumulativeBalance = ($cumulativeBalance != null) ? $cumulativeBalance->cumulative_balance + $request->sub_total : $request->sub_total;

        $postEntries = GeneralLedger::create([
           'coa_id' => $request->coa,
            'journal_id' => $request->payment_journal,
            'vendor' => $request->vendor,
            'reference' => $request->description,
            'move' => $expenseCount,
            'debit' => $request->sub_total,
            'cumulative_balance' => $_cumulativeBalance,
        ]);
        if($registerExpense && $postEntries){
            $data = ['success' => true, 'message'=> 'Expense Successfully Recorded.'];
            return response()->json($data);
        }

    }

    public function cancelPostedExpense(Request $request)
    {
        $cancelEntry = Expense::where('expense_number',$request->expenseID)->update(['status' => 'Cancelled']);
        $transactions_1 = Expense::where('expense_number',$request->expenseID)->delete();
        $transactions_2 = GeneralLedger::where('move',$request->expenseID)->delete();
        if($transactions_1 && $transactions_2 && $cancelEntry){
            $data = ['warning' => true, 'message'=> 'Expense Successfully Cancelled'];
            return response()->json($data);
        }

    }

    public function repostCancelledExpenses(Request $request)
    {
       //still working on this - recompute entries.
        Expense::onlyTrashed()->where('expense_number',$request->expenseNumber)->restore();

        $repostEntry1 = Expense::where('expense_number',$request->expenseNumber)->update([
            'status'=>'Posted',
            'description' => $request->description,
            'account_id' => $request->coa,
            'unit_price' => $request->unit_price,
            'quantity' => $request->quantity,
            'total_price' => $request->sub_total,
            'vendor' => $request->vendor,
            'posted_by' => Auth::id(),
            'expense_number'=>$request->expenseNumber,
            'product_service'=>$request->product,
        ]);

        GeneralLedger::onlyTrashed()->where('move',$request->expenseNumber)->restore();
        $cumulativeBalance = GeneralLedger::where('move',$request->expenseNumber)->first();
        $_cumulativeBalance = $cumulativeBalance->cumulative_balance + $request->sub_total;

        $repostEntry2 = GeneralLedger::where('move',$request->expenseNumber)->update([
            'coa_id' => $request->coa,
            'journal_id' => $request->payment_journal,
            'vendor' => $request->vendor,
            'reference' => $request->description,
            'move' => $request->expenseNumber,
            'debit' => $request->sub_total,
            'cumulative_balance' => $_cumulativeBalance,
        ]);

        if($repostEntry1 && $repostEntry2){
            $data = ['success' => true, 'message'=> 'Expense Successfully Reposted'];
            return response()->json($data);
        }

    }
}
