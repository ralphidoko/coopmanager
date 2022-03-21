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

class AdminMonthlyGroupedIncomeExports implements WithHeadings, WithMapping,FromCollection,WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;

    protected $startYear,$endYear;

    function __construct($startYear,$endYear)
    {
        $this->startYear = $startYear;
        $this->endYear = $endYear;
    }

    public function collection()
    {
        //get monthly grouped income
        $incomeGroupings = DB::table('incomes')->SELECT(DB::raw("income_type"),DB::raw("DATE_FORMAT(created_at, '%M-%Y') year"),DB::raw('SUM(income_realized) income_realized'))
           //->where([['created_at','LIKE','%'.$this->currentYear.'%']])
            ->where([['created_at','LIKE','%'.$this->startYear.'%']])
            ->Orwhere([['created_at','LIKE','%'.$this->endYear.'%']])
            ->groupBy(DB::raw('year'))->get();

        $totalGroupedIncome = 0;
        foreach ($incomeGroupings as $incomeGrouping){
            $totalGroupedIncome = $totalGroupedIncome + $incomeGrouping->income_realized;
        }
        if (count($incomeGroupings) > 0) {
            Toastr::success('Monthly grouped income successfully downloaded', 'Done!', ["positionClass" => "toast-top-right"]);
            return $incomeGroupings;
        }else{
            Toastr::warning('No transaction(s) found for the period!', 'Opps!', ["positionClass" => "toast-top-right"]);
            return redirect()->bacK();
        }
    }

    public function headings(): array{
    return[
        ["MONTHLY CATEGORIZED INCOME FOR THE PERIOD ".$this->startYear.'-'.$this->endYear],
        ['Description','Financial Year', 'Total Deposits(N)',],
    ];
}
    public function map($incomeGroupings): array
{
    return [
        $incomeGroupings->income_type,
        $incomeGroupings->year,
        $incomeGroupings->income_realized,
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
