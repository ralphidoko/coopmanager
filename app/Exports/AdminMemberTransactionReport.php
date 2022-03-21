<?php

namespace App\Exports;

use App\Transaction;
use Brian2694\Toastr\Facades\Toastr;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class AdminMemberTransactionReport implements FromCollection,WithHeadings,WithEvents,WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;

    protected $startDate,$endDate;

    function __construct($startDate,$endDate) {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        $memberTotalTransactions = Transaction::whereBetween('created_at', [$this->startDate, $this->endDate])
            ->selectRaw('user_id, sum(transaction_amount) as total_transaction')
            ->groupBy('user_id')
            ->get();
        if($memberTotalTransactions){
            Toastr::success('Members transaction statement successfully downloaded', 'Done!', ["positionClass" => "toast-top-right"]);
            return $memberTotalTransactions;
        }else{
            Toastr::warning('No transaction(s) found for the period!', 'Opps!', ["positionClass" => "toast-top-right"]);
            return redirect()->bacK();
        }
    }

    public function headings(): array{
        return[
            ['Member Name','Total Transaction(N)'],
        ];
    }

    public function map($memberTotalTransactions): array
    {
        return [
            $memberTotalTransactions->users->name,
            $memberTotalTransactions->total_transaction
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
