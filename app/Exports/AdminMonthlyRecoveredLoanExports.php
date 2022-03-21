<?php

namespace App\Exports;

use App\Loan;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class AdminMonthlyRecoveredLoanExports implements WithHeadings, WithMapping,FromCollection,WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */

    use Exportable;

    protected $currentYear,$startDate,$endDate;

    function __construct($startDate,$endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }
    public function collection()
    {
        $monthlyRecoveredLoans = DB::table('loans')->SELECT(DB::raw("DATE_FORMAT(created_at, '%M-%Y') month_year"),DB::raw('SUM(amount_recovered) amount_recovered'))
            //->where([['created_at','LIKE','%'.$this->currentYear.'%'],['status','!=','Awaiting Approved'],['status','!=','Rejected']])
            ->where('status','!=','Processing')
            ->where('status','!=','Rejected')
            ->whereBetween('created_at',[$this->startDate,$this->endDate])
            ->groupBy(DB::raw('month_year'))->orderByDesc(DB::raw('month_year'))->get();
        $totalRecoveredLoan = 0;
        foreach ($monthlyRecoveredLoans as $monthlyRecoveredLoan){
            $totalRecoveredLoan = $totalRecoveredLoan + $monthlyRecoveredLoan->amount_recovered;
        }
        if(!is_null($monthlyRecoveredLoans)){
            Toastr::success('Monthly recovered loans successfully downloaded', 'Done!', ["positionClass" => "toast-top-right"]);
            return $monthlyRecoveredLoans;
        }else{
            Toastr::warning('No transaction(s) found for the period!', 'Opps!', ["positionClass" => "toast-top-right"]);
            return redirect()->bacK();
        }
    }

    public function headings(): array{

        return[
            ["MONTHLY RECOVERED LOANS FOR THE PERIOD ".date('d-m-Y',strtotime($this->startDate)).'-'.date('d-m-Y',strtotime($this->endDate))],
            ['Description', 'Value Month', 'Total Recovered(N)',],
        ];
    }
    public function map($monthlyRecoveredLoans): array
    {
        return [
            'Loan Recovered',
            $monthlyRecoveredLoans->month_year,
            $monthlyRecoveredLoans->amount_recovered,
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
                $event->sheet->getDelegate()->getStyle($cellRange1)->getFont()->setBold(true)->setSize(12);
                $event->sheet->getDelegate()->getStyle($cellRange2)->getFont()->setBold(true)->setSize(11);
            },
        ];
    }

}
