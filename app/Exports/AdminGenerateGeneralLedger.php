<?php

namespace App\Exports;

use App\GeneralLedger;
use Brian2694\Toastr\Facades\Toastr;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class AdminGenerateGeneralLedger implements WithHeadings,WithEvents,FromCollection,WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */

    use Exportable;

    protected $startDate,$endDate,$chartOfAccountIDs,$balance;

    function __construct($startDate,$endDate,$chartOfAccountIDs) {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->chartOfAccountIDs = $chartOfAccountIDs;
    }

    public function collection()
    {
        $chartOfAccounts = GeneralLedger::whereIn('coa_id',$this->chartOfAccountIDs)->whereBetween('created_at', [$this->startDate, $this->endDate])->groupBy('coa_id')->get();
        if($chartOfAccounts){
            Toastr::success('Total Savings Account statement successfully downloaded', 'Done!', ["positionClass" => "toast-top-right"]);
            return $chartOfAccounts;
        }else{
            Toastr::warning('No transaction(s) found for the period!', 'Opps!', ["positionClass" => "toast-top-right"]);
            return redirect()->bacK();
        }
    }

    public function headings(): array{
        return[
            ['Code', 'Account','Cumulative Balance(N)'],
        ];
    }

    public function map($chartOfAccounts): array
    {
        $cumulativeBalance = 0;
        $relatedEntries = GeneralLedger::where('coa_id',$chartOfAccounts->coa_id)->whereBetween('created_at', [$this->startDate, $this->endDate])->get();
        foreach($relatedEntries as $relatedEntry){
            $cumulativeBalance = ($relatedEntry->debit != 0.00) ?
            $cumulativeBalance + $relatedEntry->debit : $cumulativeBalance + $relatedEntry->credit;
        }

        return [
            $chartOfAccounts->chart_of_accounts->code,
            $chartOfAccounts->chart_of_accounts->name,
            $cumulativeBalance
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
                $event->sheet->getDelegate()->getStyle($cellRange1)->getFont()->setBold(true)->setSize(12);
            },
        ];
    }
}
