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

class AdminMonthlyIncomeWithSourceExports implements  WithHeadings, WithMapping,FromCollection,WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */
    use Exportable;

    protected $startDate,$endDate;

    function __construct($startDate,$endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        //get monthly income with sources
        $monthlyIncomes = DB::table('incomes')->SELECT(DB::raw("DATE_FORMAT(created_at,'%Y-%m') recorded_on"),DB::raw("DATE_FORMAT(created_at, '%M-%Y') month_year"),DB::raw('SUM(income_realized) income_realized'))
            //->where([['created_at','LIKE','%'.$this->currentYear.'%']])
            ->whereBetween('created_at',[$this->startDate,$this->endDate])
            ->groupBy(DB::raw('month_year'))->orderByDesc(DB::raw('id'))->get();
        $totalMonthlyIncome = 0;
        foreach ($monthlyIncomes as $monthlyIncome){
            $totalMonthlyIncome = $totalMonthlyIncome + $monthlyIncome->income_realized;
        }
        if(!is_null($monthlyIncomes)){
            Toastr::success('Monthly income successfully downloaded', 'Done!', ["positionClass" => "toast-top-right"]);
            return $monthlyIncomes;
        }else{
            Toastr::warning('No transaction(s) found for the period!', 'Opps!', ["positionClass" => "toast-top-right"]);
            return redirect()->bacK();
        }
    }
    public function headings(): array{
        return[
            ["MONTHLY INCOME FOR THE PERIOD ".date('d-m-Y',strtotime($this->startDate)).'-'.date('d-m-Y',strtotime($this->endDate))],
            ['Description', 'Value Month', 'Total Income Realized(N)',],
        ];
    }
    public function map($monthlyIncomes): array
    {
        return [
            'Income Realized',
            $monthlyIncomes->month_year,
            $monthlyIncomes->income_realized,
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
