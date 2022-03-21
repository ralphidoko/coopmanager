<?php

namespace App\Exports;

use App\Transaction;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;


class ExcelFilteredTransactionStatement implements WithHeadings, WithMapping,FromCollection,WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */
    use Exportable;

    protected $start_date;
    protected $end_date;

    function __construct($start_date,$end_date) {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    public function collection()
    {
        $transactions = Transaction::where('user_id', '=', Auth::id())
            ->whereBetween('created_at', [$this->start_date . '%', $this->end_date . '%'])
            ->get();
        if(!is_null($transactions)){
            Toastr::success('Transaction statement successfully downloaded', 'Done!', ["positionClass" => "toast-top-right"]);
            return $transactions;
        }else{
            Toastr::warning('No transaction(s) found for the selected period!', 'Opps!', ["positionClass" => "toast-top-right"]);
            return redirect()->bacK();
        }
    }
    public function headings(): array
    {
        return [
            'Transaction Type',
            'Transaction Action',
            'Channel',
            'Transaction Reference',
            'Transaction Amount(N)',
            'Transaction Date',
        ];

    }

    public function map($transactions): array
    {
        return [
            $transactions->transaction_type,
            $transactions->transaction_action,
            $transactions->channel,
            $transactions->transaction_reference,
            $transactions->transaction_amount,
            date('d-m-Y',strtotime($transactions->created_at)),
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
