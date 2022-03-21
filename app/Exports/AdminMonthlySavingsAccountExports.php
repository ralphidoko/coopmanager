<?php

namespace App\Exports;

use App\Saving;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class AdminMonthlySavingsAccountExports implements WithHeadings, WithMapping,FromCollection,WithEvents
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
        //monthly members' deposits
        $monthlySavings = DB::table('savings')->SELECT(DB::raw('description'),DB::raw("DATE_FORMAT(month, '%M-%Y') month_year"),DB::raw('MONTH(month) month'),DB::raw('SUM(amount_saved) amount_saved'))
            //->where([['month','LIKE','%'.$this->currentYear.'%'],['description','=','Monthly Savings']])
            ->where('description','!=','Savings Withdrawal')
            ->whereBetween('month',[$this->startDate,$this->endDate])
            ->groupBy(DB::raw('month_year'))->orderByDesc(DB::raw('id'))->get();
        $totalDeposit = 0;
        foreach ($monthlySavings as $monthlySaving){
            $totalDeposit = $totalDeposit + $monthlySaving->amount_saved;
        }
        if(!is_null($monthlySavings)){
            Toastr::success('Total Savings Account statement successfully downloaded', 'Done!', ["positionClass" => "toast-top-right"]);
            return $monthlySavings;
        }else{
            Toastr::warning('No transaction(s) found for the period!', 'Opps!', ["positionClass" => "toast-top-right"]);
            return redirect()->bacK();
        }

    }
    public function headings(): array{
        $balanceBroughtForward = Saving::where('month','LIKE','%'.$this->previousYear.'%')->sum('amount_saved');
        return[
            ["SAVINGS ACCOUNT STATEMENT FOR THE ".date('d-m-Y',strtotime($this->startDate)).'--'.date('d-m-Y',strtotime($this->endDate))],
            ['Description', 'Value Month', 'Total Deposits(N)',],
            ['Bal Bfwd', '',$balanceBroughtForward,]
        ];
    }
    public function map($monthlySavings): array
    {
        return [
            $monthlySavings->description,
            $monthlySavings->month_year,
            $monthlySavings->amount_saved,
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
                $event->sheet->getDelegate()->getStyle($cellRange1)->getFont()->setBold(true)->setSize(13);
                $event->sheet->getDelegate()->getStyle($cellRange2)->getFont()->setBold(true)->setSize(12);
                $event->sheet->getDelegate()->getStyle($cellRange3)->getFont()->setBold(true)->setSize(12);
            },
        ];
    }
}
