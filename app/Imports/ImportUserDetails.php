<?php

namespace App\Imports;

use App\Member;
use App\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ImportUserDetails implements ToModel,WithHeadingRow, WithChunkReading
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

    public function chunkSize(): int
    {
        // TODO: Implement chunkSize() method.
        return 50;
    }

    public function model(array $row)
    {
        $membershipID = sprintf('MBN'."%'.03d",$row['member_id']);
        return new Member([
            'id' => sha1(time()),
            'first_name' => $row['first_name'],
            'middle_name' => $row['middle_name'],
            'last_name' => $row['last_name'],
            'staff_no' => $row['staff_no'],
            'residential_address' => $row['residential_address'],
            'office_location' => $row['office_location'],
            'department' => $row['department'],
            'designation' => $row['designation'],
            'gender' => $row['gender'],
            'state_of_origin' => $row['state_of_origin'],
            'lga' => $row['lga'],
            'town' => $row['town'],
            'nok_fname' => $row['nok_fname'],
            'nok_relationship' => $row['nok_relationship'],
            'user_id' => $this->users[$row['ippis_no']],
            'email' => $row['email'],
            'referee_one' => $row['referee_one'],
            'referee_two' => $row['referee_two'],
            'certification' => $row['certification'],
            'approval_status' => $row['approval_status'],
            'approval_count' => $row['approval_count'],
            'membership_status' => $row['membership_status'],
            'multiple_loan_permission' => $row['multiple_loan_permission'],
            'permission_count' => $row['permission_count'],
            'member_id' => $membershipID,
        ]);

    }

}
