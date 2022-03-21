<?php

namespace App\Http\Controllers;

use App\Appropriation;
use App\Dividend;
use App\Expense;
use App\Income;
use App\IncomeDistribution;
use App\Loan;
use App\LoanIncome;
use App\Saving;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminCalculationController extends Controller
{
    //calculate cooperative income on monthly installments and update income table
    public function incomeOnLoanInstallment($loanID,$currentInstalment)
    {
        //determine the % of interest meant for cooperative income
        $loanObj = DB::table('loans')->select('total_interest_payable', 'total_amount_payable','id','user_id')->where('id',$loanID)->first();
        $incomePercentage = ($loanObj->total_interest_payable/$loanObj->total_amount_payable) * 100;
        $coopIncome = $currentInstalment * ($incomePercentage/100);

        $loanIncomeObj = Income::where('loan_id',$loanObj->id)->first();
        if($loanIncomeObj == null){
            Income::create([
                'loan_id' => $loanID,
                'income_type' => 'Interest On Loan',
                'user_id' => $loanObj->user_id,
                'income_realized' => $coopIncome,
            ]);
        }else{
            Income::where('loan_id',$loanID)->update([
                'income_realized' => $loanIncomeObj->income_realized + $coopIncome,
            ]);
        }
    }

    public function calculateRecoveredLoan($loanID,$currentInstalment)
    {
        //determine the % of loan recovered
        $loanObj = DB::table('loans')->select('loan_amount','amount_recovered', 'total_amount_payable','id')->where('id',$loanID)->first();
        $perOfLoanRecovered = ($loanObj->loan_amount/$loanObj->total_amount_payable) * 100;
        $amountRecovered = $currentInstalment * ($perOfLoanRecovered/100);

        if($loanObj){
            Loan::where('id',$loanObj->id)->update([
                'amount_recovered' => $loanObj->amount_recovered + $amountRecovered,
            ]);
        }
    }

    public function showDividendForm()
    {
        return view('dashboard.admin.accounting.declareDividends');
    }

    public function showDeclaredDividends()
    {
        $declaredDividends = DB::table('appropriations')->SELECT(DB::raw('financial_year financialYear'),DB::raw('proposed_dividend'),DB::raw('proposed_main_dividend'),DB::raw('proposed_lpd'))
            ->groupBy(DB::raw('created_at'))->orderBy('financialYear','desc')->get();
        return view('dashboard.admin.accounting.dividendsList',compact('declaredDividends'));
    }

    public function declareDividendsPostTransfers(Request $request)
    {
        if($request->previous_year == false):
            return $this->declareDividendsPostTransfersForCurrentFinancialYear();
        else:
            return $this->declareDividendsPostTransfersForPreviousFinancialYear();
        endif;
    }

    private function declareDividendsPostTransfersForCurrentFinancialYear()
    {
        $currentFinancialYear = date('Y');
        $financialMonth = date('12');
        if($financialMonth == 03){
            return back()->with('error','Dividends and transfers can only be declared at the end of financial year');
        }else{
            $totalIncome = Income::where('created_at','LIKE','%'.$currentFinancialYear.'%')->sum('income_realized');
            $totalExpenditure = Expense::where('created_at','LIKE','%'.$currentFinancialYear.'%')->sum('total_price');
            if($totalExpenditure >= $totalIncome){
                return back()->with('error',"No dividends can be declared for the current year as the Cooperative Expenditure is more than it's Income");
            }else{
                $netIncome = $totalIncome - $totalExpenditure;//calculate net income
                $educationReserve = (10/100) * $netIncome; //calculate Transfer to Education Reserve
                $statutoryReserve = (35/100) * $netIncome; //calculate Transfer to Statutory Reserve
                $proposedDividends = (55/100) * $netIncome;//calculate declared dividends
                $generalReserve = $netIncome - ($educationReserve + $statutoryReserve + $proposedDividends);//calculate Net Surplus transfer to General Reserve
                //check if transfers exist for the current year
                 $isTransferExisting = Appropriation::where('financial_year','LIKE','%'.date('Y').'%')->exists();
                 if($isTransferExisting ==true){
                     return back()->with('error',"Dividends already declared and appropriations posted for the current year");
                 }else{

                     $totalLoanValue = Loan::whereYear('created_at','=',(date('Y')))->where('status','Approved')->Orwhere('status','Settled')->sum('loan_amount');
                     $totalSavings = Saving::whereYear('month','=',(date('Y')))->sum('amount_saved');
                     $totalDrawings = Saving::whereYear('month','=',(date('Y')))->sum('amount_withdrawn');
                     $availableSavingsBalance = $totalSavings - $totalDrawings;
                     $memberWithSavings = Saving::whereYear('month','=',(date('Y')))->where('amount_saved','!=', 0.00)->distinct()->get(['user_id']);
                     $loanPatronageDividends = (10/100) * $proposedDividends; //calculate Loan Patronage Dividends (LPD)
                     $mainDividends = (90/100) * $proposedDividends; //calculate main dividends
                     //post transfers
                     $createAppropriations =  Appropriation::create([
                         'education_reserve' => $educationReserve,
                         'statutory_reserve' => $statutoryReserve,
                         'proposed_dividend' => $proposedDividends,
                         'general_reserve' => $generalReserve,
                         'financial_year' => $currentFinancialYear,
                         'proposed_main_dividend' => $mainDividends,
                         'proposed_lpd' => $loanPatronageDividends
                     ]);

                     foreach($memberWithSavings as $memberWithSaving){
                         $totalLoanByBeneficiary = Loan::where('user_id',$memberWithSaving->user_id)->whereYear('created_at','=',date('Y'))->where('status','!=','Processing')->where('status','!=','Rejected')->sum('loan_amount');
                         $memberTotalSavings = Saving::where('user_id',$memberWithSaving->user_id)->where('month','LIKE','%'.$currentFinancialYear.'%')->sum('amount_saved');
                         $memberTotalDrawings = Saving::where('user_id',$memberWithSaving->user_id)->where('month','LIKE','%'.$currentFinancialYear.'%')->sum('amount_withdrawn');
                         $memberAccountBalance = $memberTotalSavings - $memberTotalDrawings;
                         //$memberAccountBalance = Saving::where('user_id',$memberWithSaving->user_id)->latest()->value('balance');
                         $beneficiaryLoanPatronageDividend = ($totalLoanByBeneficiary/$totalLoanValue) * $loanPatronageDividends; //calculate members loan patronage dividend
                         $memberMainDividend = ($memberAccountBalance/$availableSavingsBalance) * $mainDividends; //calculate members loan main dividend
                         $totalDividends = $beneficiaryLoanPatronageDividend + $memberMainDividend; //calculate members total dividends

                         if($memberAccountBalance > 0 && $totalLoanByBeneficiary > 0):
                              $declareDividend = Dividend::create([
                                 'user_id' => $memberWithSaving->user_id,
                                 'loan_patronage_dividend' => $beneficiaryLoanPatronageDividend,
                                 'dividend' => $memberMainDividend,
                                 'total_dividends' => $totalDividends,
                                 'financial_year' => $currentFinancialYear,
                              ]);
                         elseif($memberAccountBalance > 0 && $totalLoanByBeneficiary == 0):
                              $declareDividend = Dividend::create([
                                 'user_id' => $memberWithSaving->user_id,
                                 'dividend' => $memberMainDividend,
                                 'total_dividends' => $totalDividends,
                                 'financial_year' => $currentFinancialYear,
                              ]);
                         endif;
                    }

                     if($createAppropriations && $declareDividend){
                         return back()->with('success',"Dividends have been declared and Appropriations posted for the ".date('Y')." Financial Year. \n Congratulations to NEPZA Staff Cooperative and it's Members!");
                     }else{
                         return back()->with('error','There was a problem declaring dividends and posting transfers.');
                     }

                }

            }
        }

    }

    private function declareDividendsPostTransfersForPreviousFinancialYear()
    {
        $previousFinancialYear = date('Y') - 1;
        $totalIncome = Income::where('created_at','LIKE','%'.$previousFinancialYear.'%')->sum('income_realized');
        $totalExpenditure = Expense::where('created_at','LIKE','%'.$previousFinancialYear.'%')->sum('total_price');
        if($totalExpenditure >= $totalIncome){
            return back()->with('error',"No dividends can be declared for the previous financial year as the Cooperative expenditure is more than it's income");
        }else{
            $netIncome = $totalIncome - $totalExpenditure;//calculate net income
            $educationReserve = (10/100) * $netIncome; //calculate Transfer to Education Reserve
            $statutoryReserve = (35/100) * $netIncome; //calculate Transfer to Statutory Reserve
            $proposedDividends = (55/100) * $netIncome;//calculate declared dividends
            $generalReserve = $netIncome - ($educationReserve + $statutoryReserve + $proposedDividends);//calculate Net Surplus transfer to General Reserve
            //check if transfers exist for the previous year
            $isTransferExisting = Appropriation::where('financial_year','LIKE','%'.$previousFinancialYear.'%')->exists();
            if($isTransferExisting ==true){
                return back()->with('error',"Dividends already declared and appropriations posted for the previous financial year");
            }else{

                $totalLoanValue = Loan::whereYear('created_at','=',$previousFinancialYear)->where('status','=','Approved')->Orwhere('status','Settled')->sum('loan_amount');
                $totalSavings = Saving::whereYear('month','=',$previousFinancialYear)->sum('amount_saved');
                $totalDrawings = Saving::whereYear('month','=',$previousFinancialYear)->sum('amount_withdrawn');
                $availableSavingsBalance = $totalSavings - $totalDrawings;
                $memberWithSavings = Saving::whereYear('month','=',$previousFinancialYear)->where('amount_saved','!=', 0.00)->distinct()->get(['user_id']);
                $loanPatronageDividends = (10/100) * $proposedDividends; //calculate Loan Patronage Dividends (LPD)
                $mainDividends = (90/100) * $proposedDividends; //calculate main dividends

                //post transfers
                $createAppropriations =  Appropriation::create([
                    'education_reserve' => $educationReserve,
                    'statutory_reserve' => $statutoryReserve,
                    'proposed_dividend' => $proposedDividends,
                    'general_reserve' => $generalReserve,
                    'financial_year' => $previousFinancialYear,
                    'proposed_main_dividend' => $mainDividends,
                    'proposed_lpd' => $loanPatronageDividends
                ]);

                foreach($memberWithSavings as $memberWithSaving){
                    $totalLoanByBeneficiary = Loan::where('user_id',$memberWithSaving->user_id)->whereYear('created_at','=',$previousFinancialYear)->where('status','!=','Processing')->where('status','!=','Rejected')->sum('loan_amount');
                    $memberTotalSavings = Saving::where('user_id',$memberWithSaving->user_id)->where('month','LIKE','%'.$previousFinancialYear.'%')->sum('amount_saved');
                    $memberTotalDrawings = Saving::where('user_id',$memberWithSaving->user_id)->where('month','LIKE','%'.$previousFinancialYear.'%')->sum('amount_withdrawn');
                    $memberAccountBalance = $memberTotalSavings - $memberTotalDrawings;
                    //$memberAccountBalance = Saving::where('user_id',$memberWithSaving->user_id)->whereYear('month','LIKE','%'.$previousFinancialYear.'%')->latest()->value('balance');
                    $beneficiaryLoanPatronageDividend = ($totalLoanByBeneficiary/$totalLoanValue) * $loanPatronageDividends; //calculate members loan patronage dividend
                    $memberMainDividend = ($memberAccountBalance/$availableSavingsBalance) * $mainDividends; //calculate members loan main dividend
                    $totalDividends = $beneficiaryLoanPatronageDividend + $memberMainDividend; //calculate members total dividends

                   if($memberAccountBalance > 0 && $totalLoanByBeneficiary > 0):
                        $declareDividend = Dividend::create([
                            'user_id' => $memberWithSaving->user_id,
                            'loan_patronage_dividend' => $beneficiaryLoanPatronageDividend,
                            'dividend' => $memberMainDividend,
                            'total_dividends' => $totalDividends,
                            'financial_year' => $previousFinancialYear,
                        ]);
                   elseif($memberAccountBalance > 0 && $totalLoanByBeneficiary == 0):
                        $declareDividend = Dividend::create([
                            'user_id' => $memberWithSaving->user_id,
                            'dividend' => $memberMainDividend,
                            'total_dividends' => $totalDividends,
                            'financial_year' => $previousFinancialYear,
                        ]);
                   endif;
                }

                if($createAppropriations && $declareDividend){
                    return back()->with('success',"Dividends have been declared and Appropriations posted for the ".$previousFinancialYear." Financial Year. \n Congratulations to NEPZA Staff Cooperative and it's Members!");
                }else{
                    return back()->with('error','There was a problem declaring dividends and posting transfers.');
                }

            }

        }
    }


}
