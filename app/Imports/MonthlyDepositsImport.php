<?php

namespace App\Imports;

use App\Saving;
use App\User;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Carbon\Carbon;

class MonthlyDepositsImport implements ToModel,WithHeadingRow,WithValidation
{
    use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    private $users;

    public function __construct()
    {
        $this->users = User::all(['id', 'ippis_no'])->pluck('id', 'ippis_no');
    }

    public function rules(): array
    {
        return [
            'ippis_no'  => 'required',
            'description' => 'required',
            'amount_saved'  => 'required|numeric',
            'month'        => 'required|date_format:d-m-Y',
        ];
    }

    public function customValidationMessages()
    {
        return [

            'ippis_no.required'    => 'IPPIS No is required for all records',
            'description.required' => 'Description field is required!',
            'amount.numeric'         => 'Incorrect currency format.',
            'month.required'       => 'Month field cannot be empty for all records',

        ];
    }


    public function model(array $row)
    {
        return new Saving([
            'user_id' =>  $this->users[$row['ippis_no']],
            'ippis_no' => $row['ippis_no'],
            'description' => $row['description'],
            'amount_saved' => floatval($row['amount_saved']),
            'month'        => \Carbon\Carbon::parse($row['month'])->format('Y-m-d'),
        ]);

    }



}
