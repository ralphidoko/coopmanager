<?php

namespace App\Exports;

use App\Loan;
use App\Saving;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class AdminMonthlyApprovedLoanExports implements  WithHeadings, WithMapping,FromCollection,WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;

    protected $currentYear,$previousYear,$startDate,$endDate;

    function __construct($currentYear,$previousYear,$startDate,$endDate)
    {
        $this->currentYear = $currentYear;
        $this->previousYear = $previousYear;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        //get monthly approved loan
        $monthlyApprovedLoans = DB::table('loans')->SELECT(DB::raw("DATE_FORMAT(created_at, '%M-%Y') month_year"),DB::raw('SUM(loan_amount) loan_amount'))
            //->where([['created_at','LIKE','%'.$this->currentYear.'%'],['status','=','Approved']])
            ->where('status','=','Approved')
            ->whereBetween('created_at',[$this->startDate,$this->endDate])
            ->groupBy(DB::raw('month_year'))->orderByDesc(DB::raw('month_year'))->get();
        $totalApprovedLoan = 0;
        foreach ($monthlyApprovedLoans as $monthlyApprovedLoan){
            $totalApprovedLoan = $totalApprovedLoan + $monthlyApprovedLoan->loan_amount;
        }
        if(!is_null($monthlyApprovedLoans)){
            Toastr::success('Monthly approved loans successfully downloaded', 'Done!', ["positionClass" => "toast-top-right"]);
            return $monthlyApprovedLoans;
        }else{
            Toastr::warning('No transaction(s) found for the period!', 'Opps!', ["positionClass" => "toast-top-right"]);
            return redirect()->bacK();
        }
    }
    public function headings(): array{

        //get the balance brought forward
        $loanBalBroughtForward = Loan::where([['created_at','LIKE','%'.$this->previousYear.'%'],['status','=','Approved']])->sum('loan_amount');
        return[
            ["MONTHLY APPROVED LOANS FOR THE PERIOD ".date('d-m-Y',strtotime($this->startDate)).'-'.date('d-m-Y',strtotime($this->endDate))],
            ['Description', 'Value Month', 'Total Deposits(N)',],
            ['Bal Bfwd', '',$loanBalBroughtForward,]
        ];
    }
    public function map($monthlyApprovedLoans): array
    {
        return [
            'Loan Granted',
            $monthlyApprovedLoans->month_year,
            $monthlyApprovedLoans->loan_amount,
        ];
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange1 = 'A1:W1'; // All headers
                $cellRange2 = 'A1:W2'; // All headers
                $cellRange3 = 'A1:W3'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange1)->getFont()->setBold(true)->setSize(12);
                $event->sheet->getDelegate()->getStyle($cellRange2)->getFont()->setBold(true)->setSize(11);
                $event->sheet->getDelegate()->getStyle($cellRange3)->getFont()->setBold(true)->setSize(11);
            },
        ];
    }
}
