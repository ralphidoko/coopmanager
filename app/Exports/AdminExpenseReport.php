<?php

namespace App\Exports;

use App\Expense;
use Brian2694\Toastr\Facades\Toastr;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class AdminExpenseReport implements FromCollection,WithHeadings,WithEvents,WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */

    use Exportable;

    protected $startDate,$endDate,$chartOfAccountIDs,$balance;

    function __construct($startDate,$endDate) {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        $coopExpenses = Expense::whereBetween('created_at', [$this->startDate, $this->endDate])->get();
        $totalExpense = 0;

        foreach ($coopExpenses as $coopExpense){
            $totalExpense = $totalExpense + $coopExpense->total_price;
        }
        if($coopExpenses){
            Toastr::success('Total Savings Account statement successfully downloaded', 'Done!', ["positionClass" => "toast-top-right"]);
            return $coopExpenses;
        }else{
            Toastr::warning('No transaction(s) found for the period!', 'Opps!', ["positionClass" => "toast-top-right"]);
            return redirect()->bacK();
        }
    }

    public function headings(): array{
        return[
            ['Date', 'Vendor','Reference','Product/Service','Quantity','Unit Price(N)','Sub Total(N)'],
        ];
    }

    public function map($coopExpenses): array
    {
        return [
            date('d-m-Y',strtotime($coopExpenses->created_at)),
            $coopExpenses->vendor,
            $coopExpenses->description,
            $coopExpenses->product_service,
            $coopExpenses->quantity,
            $coopExpenses->unit_price,
            $coopExpenses->total_price
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
                $event->sheet->getDelegate()->getStyle($cellRange1)->getFont()->setBold(true)->setSize(11);
            },
        ];
    }
}

