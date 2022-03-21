<?php

namespace App\Http\Controllers;

use App\Exports\DownloadAdminSavingsTemplate;
use App\Imports\ImportAccountStatement;
use App\Imports\ImportMemberLoan;
use App\Imports\ImportMembers;
use App\Imports\ImportUserDetails;
use App\Imports\MonthlyDepositsImport;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class AdminFileManagementController extends Controller
    {
        //
       public function showMonthlyDepositUploadForm(Request $request)
       {
           return view('dashboard.admin.adminFile.monthlyDepositUpload');
       }

        public function showImportModelForm(Request $request)
        {
            if(Auth::user()->name != 'Administrator'):
                abort(403,'Unauthorized Access');
            else:
                return view('dashboard.admin.settings.importModels');
            endif;
        }

        public function downloadSavingsTemplate()
        {
            return (new DownloadAdminSavingsTemplate())->download('MonthlyDepositTemplate.xlsx');
        }

        public function importMonthlyDeposit(Request $request)
        {
            if ($request->hasFile('deposit_file')) {
                $updateFile = $request->file('deposit_file');

                $path = $updateFile->getRealPath();
                $fileExtension = $updateFile->getClientOriginalExtension();

                $formats = ['xls', 'xlsx', 'csv'];
                if (!in_array($fileExtension, $formats)) {
                    return redirect()->back()->with('error' ,"Selected file extension not allowed. Only files with 'xls', 'xlsx', 'csv' extensions are allowed");
                }

                $file = $request->file('deposit_file');
                (new MonthlyDepositsImport)->import($file);
                Toastr::success('Savings Deposit Successfully Uploaded!', 'Success!', ["positionClass" => "toast-top-right"]);
                return redirect()->bacK();//->with('success','Monthly Savings Successfully Uploaded!');


            }else{
                return redirect()->back()->with('warning','Please select a file to upload.');
            }

        }

        public function importSomeModels(Request $request)
        {
            if ($request->hasFile('model_file')) {
                $updateFile = $request->file('model_file');

                $path = $updateFile->getRealPath();
                $fileExtension = $updateFile->getClientOriginalExtension();

                $allowedFormats = ['xls', 'xlsx', 'csv'];
                if (!in_array($fileExtension, $allowedFormats)) {
                    return redirect()->back()->with('error' ,"Selected file extension not allowed. Only files with 'xls', 'xlsx', 'csv' extensions are allowed");
                }else {
                    if($request->model_type == 'users'):return $this->importMembers($request);
                    elseif ($request->model_type == 'user_details'):return $this->importUserDetails($request);
                    elseif ($request->model_type == 'loans'):return $this->importMemberLoans($request);
                    elseif ($request->model_type == 'instalments'):return $this->importInstalments($request);
                    elseif ($request->model_type == 'account_statement'):return $this->importAccountStatement($request);
                    endif;

                    $file = $request->file('model_file');
                    (new MonthlyDepositsImport)->import($file);
                    Toastr::success('Savings Deposit Successfully Uploaded!', 'Success!', ["positionClass" => "toast-top-right"]);
                    return redirect()->bacK();//->with('success','Monthly Savings Successfully Uploaded!');
                }

            }else{
                return redirect()->back()->with('warning','Please select a file to upload.');
            }

        }
        private function importMembers($request)
        {
            $file = $request->file('model_file');
            (new ImportMembers)->import($file);
            Toastr::success('Member data successfully imported!', 'Success!', ["positionClass" => "toast-top-right"]);
            return redirect()->bacK();//->with('success','Monthly Savings Successfully Uploaded!');
        }

        private function importUserDetails($request)
        {
            $file = $request->file('model_file');
            (new ImportUserDetails)->import($file);
            Toastr::success('User Details Successfully Imported!', 'Success!', ["positionClass" => "toast-top-right"]);
            return redirect()->bacK();//->with('success','Monthly Savings Successfully Uploaded!');
        }

        private function importMemberLoans($request)
        {
            $file = $request->file('model_file');
            (new ImportMembers)->import($file);
            Toastr::success('Savings Deposit Successfully Uploaded!', 'Success!', ["positionClass" => "toast-top-right"]);
            return redirect()->bacK();//->with('success','Monthly Savings Successfully Uploaded!');
        }

        private function importInstalments($request)
        {
            $file = $request->file('model_file');
            (new ImportMemberLoan)->import($file);
            Toastr::success('Savings Deposit Successfully Uploaded!', 'Success!', ["positionClass" => "toast-top-right"]);
            return redirect()->bacK();//->with('success','Monthly Savings Successfully Uploaded!');
        }

        private function importAccountStatement($request)
        {
            $file = $request->file('model_file');
            (new ImportAccountStatement)->import($file);
            Toastr::success('Savings Deposit Successfully Uploaded!', 'Success!', ["positionClass" => "toast-top-right"]);
            return redirect()->bacK();//->with('success','Monthly Savings Successfully Uploaded!');
        }


    }
