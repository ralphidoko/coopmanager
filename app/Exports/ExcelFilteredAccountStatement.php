<?php

namespace App\Exports;

use App\Saving;
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

class ExcelFilteredAccountStatement implements WithHeadings, WithMapping,FromCollection,WithEvents
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
        $savings = DB::table('savings')
            ->where('user_id', Auth::id())
            ->whereBetween('month', [$this->start_date,$this->end_date])
            ->select('month', 'description', 'amount_saved', 'amount_withdrawn', 'balance')
            ->orderBy('id')
            ->get();
        if(!is_null($savings)){
            Toastr::success('Account statement successfully downloaded', 'Done!', ["positionClass" => "toast-top-right"]);
            return $savings;
        }else{
            Toastr::warning('No transaction(s) found for the selected period!', 'Opps!', ["positionClass" => "toast-top-right"]);
            return redirect()->bacK();
        }

    }
    public function headings(): array{
        return[
            'Date',
            'Description',
            'Amount Saved',
            'Amount Withdrawn(N)',
            'Balance(N)'
        ];
    }
    public function map($saving): array
    {
        return [
            $saving->month,
            //saving'XXXXXXXXXXXX' . substr($transaction->card_no, -4, 4),
            $saving->description,
            $saving->amount_saved,
            $saving->amount_withdrawn,
            $saving->balance,
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
