<?php

namespace App\Exports;

use App\Loan;
use Barryvdh\DomPDF\PDF;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ExcelFilteredLoanStatement implements WithHeadings, WithMapping,FromCollection,WithEvents
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
        $loans = Loan::where([['user_id', '=', Auth::id()], ['status', '!=', 'Processing']])
            ->whereBetween('created_at', [$this->start_date . '%', $this->end_date . '%'])
            ->get();
        $total_loan = 0;
        $total_interest_payable = 0;
        $total_payable = 0;
        foreach ($loans as $loan) {
            $total_loan = $total_loan + $loan->loan_amount;
            $total_interest_payable = $total_interest_payable + $loan->total_interest_payable;
            $total_payable = $total_payable + $loan->total_amount_payable;
        }

        if(!is_null($loans)){
            Toastr::success('Loan statement successfully downloaded', 'Done!', ["positionClass" => "toast-top-right"]);
            return $loans;
        }else{
            Toastr::warning('No transaction(s) found for the selected period!', 'Opps!', ["positionClass" => "toast-top-right"]);
            return redirect()->bacK();
        }
    }
    public function headings(): array
    {
        return [
            'Date',
            'Loan Type',
            'Loan Amount',
            'Interest Rate (%)',
            'Loan Tenor (Month)',
            'Total Interest Payable(N)',
            'Total Amount Payable(N)',
        ];
    }

   public function map($loan): array
    {
        $loan_tenor = 0;
        $loan_rate = 0;

        if($loan->loan_type == 'Household Equipment Loan'){
            $loan_tenor = $loan->item_loan_tenor;
            $loan_rate = ($loan->item_loan_rate*100)/100;
        }else{
            $loan_tenor = $loan->cash_loan_tenor;
            $loan_rate = ($loan->cash_loan_rate/100)*100;
        }
        return [
            date('d/m/Y',strtotime($loan->created_at)),
            $loan->loan_type,
            $loan->loan_amount,
            $loan_rate,
            $loan_tenor,
            $loan->total_interest_payable,
            $loan->total_amount_payable,
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
