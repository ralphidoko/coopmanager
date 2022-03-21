<?php

namespace App\Imports;


use App\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ImportMembers implements ToModel,WithHeadingRow,WithValidation,WithChunkReading
{
    use Importable;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function rules(): array
    {
        return [
            'name' => 'required',
            'phone_no' => 'required',
            'email' => 'required',
            'membership_status' => 'required',
            'is_verified' => 'required',
            'ippis_no'  => 'required',
            'member_id'  => 'required',
           // 'date_admitted' => 'required|date_format:d-m-Y',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'name.required' => 'Name is required for all fields',
            'phone_no.required' => 'Provide phone number for all fields',
            'email.required' => 'Email is required',
            'membership_status.required' => 'Provide membership status for all fields (MUST be boolean)',
            'is_verified.required' => 'Provide verification status for all fields (MUST be boolean)',
            'ippis_no.required'  => 'Provide Staff number for all members',
            'member_id.required'  => 'All members MUST have membership number',
            //'date_admitted.required' => 'required|date_format:d-m-Y',
        ];
    }

    public function chunkSize(): int
    {
        // TODO: Implement chunkSize() method.
        return 50;
    }

    public function model(array $row)
    {
        $hashedPassword = Hash::make($row['email']);
        return new User([
            'id' => sha1(time()),
            'name' => $row['name'],
            'phone_no' => $row['phone_no'],
            'email' => $row['email'],
            'password' => $hashedPassword,
            'membership_status' => $row['membership_status'],
            'is_verified' => $row['is_verified'],
            'ippis_no' => $row['ippis_no'],
            'date_admitted' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['date_admitted'])->format('Y-m-d')
        ]);

    }

}
