<?php

namespace App\Exports;

use App\Appropriation;
use Brian2694\Toastr\Facades\Toastr;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;

class AdminGenerateYearlyDividend implements WithHeadings, WithMapping,FromCollection,WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;

    protected $startDate, $endDate;

    function __construct($startDate,$endDate) {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        //
        $declaredDividends = Appropriation::whereBetween('created_at', [$this->startDate, $this->endDate])->groupBy('created_at')->get();

        if(!is_null($declaredDividends)){
            Toastr::success('Monthly income successfully downloaded', 'Done!', ["positionClass" => "toast-top-right"]);
            return $declaredDividends;
        }else{
            Toastr::warning('No transaction(s) found for the period!', 'Opps!', ["positionClass" => "toast-top-right"]);
            return redirect()->bacK();
        }
    }
    public function headings(): array{
        return[
            ["YEARLY DIVIDENDS DECLARED FOR THE PERIOD ".date('Y',strtotime($this->startDate)).'-'.date('Y',strtotime($this->endDate))],
            ['Financial Year','Total Declared Dividend(N)',],
        ];
    }
    public function map($declaredDividends): array
    {
        return [
            date('Y',strtotime($declaredDividends->created_at)),
            $declaredDividends->proposed_dividend,
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
