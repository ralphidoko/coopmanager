<?php

namespace App\Exports;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class AdminMonthlyWithdrawalAccountExports implements WithHeadings, WithMapping,FromCollection,WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;

    protected $currentYear,$startDate,$endDate;

    function __construct($currentYear,$startDate,$endDate)
    {
        $this->currentYear = $currentYear;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }
    public function collection()
    {
        //monthly members' drawings
        $monthlyDrawings = DB::table('savings')->SELECT(DB::raw('description'),DB::raw("DATE_FORMAT(month, '%M-%Y') month_year"),DB::raw('MONTH(month) month'),DB::raw('SUM(amount_withdrawn) amount_withdrawn'))
            //->where([['month','LIKE','%'.$this->currentYear.'%'],['description','=','Savings Withdrawal']])
            ->where('description','=','Savings Withdrawal')
            ->whereBetween('month',[$this->startDate,$this->endDate])
            ->groupBy(DB::raw('month_year'))->orderByDesc(DB::raw('id'))->get();

        if (count($monthlyDrawings) > 0 ) {
            Toastr::success('Withdrawal statement successfully downloaded', 'Done!', ["positionClass" => "toast-top-right"]);
            return $monthlyDrawings;
        }else {
            Toastr::warning('No loan(s) found for the period!', 'Opps!', ["positionClass" => "toast-top-right"]);
            return redirect()->bacK();
        }
    }
    public function headings(): array{
        return[
            ["SAVINGS WITHDRAWAL STATEMENT FOR THE ".date('d-m-Y',strtotime($this->startDate)).'--'.date('d-m-Y',strtotime($this->endDate))],
            ['Description', 'Value Month', 'Total Withdrawal(N)',],
        ];
    }
    public function map($monthlySavings): array
    {
        return [
            $monthlySavings->description,
            $monthlySavings->month_year,
            $monthlySavings->amount_withdrawn,
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
