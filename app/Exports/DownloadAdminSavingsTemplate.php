<?php

namespace App\Exports;

use App\AuthorityToDeductPay;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class DownloadAdminSavingsTemplate implements WithHeadings, WithMapping,FromCollection,WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */
    use Exportable;

    function __construct() {

    }

    public function collection()
    {
        $savings = AuthorityToDeductPay::where('status','Approved')->get();

        if(!is_null($savings)){
            Toastr::success('Loan statement successfully downloaded', 'Done!', ["positionClass" => "toast-top-right"]);
            return $savings;
        }else{
            Toastr::warning('No transaction(s) found for the selected period!', 'Opps!', ["positionClass" => "toast-top-right"]);
            return redirect()->bacK();
        }
    }
    public function headings(): array
    {
        return [
            "name",
            'ippis_no',
            'description',
            'amount_saved',
            'month',
        ];
    }

    public function map($savings): array
    {
        return [
            $savings->users->name,
            $savings->users->ippis_no,
            'Monthly Savings',
            $savings->authorized_amount,
            date('d-m-Y',strtotime($savings->start_date)),
        ];
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:W1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold(true)->setSize(12);
            },
        ];
    }

}
