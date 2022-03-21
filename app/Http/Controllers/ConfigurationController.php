<?php

namespace App\Http\Controllers;

use App\Charges;
use App\DepartmentAndZone;
use App\Helpers\LogActivity;
use Illuminate\Http\Request;

class ConfigurationController extends Controller
{
    public function renderConfigurationForm()
    {
        $charges = Charges::all();
        return view('dashboard.admin.settings.setUpCharges',compact('charges'));
    }

    public function renderLogView()
    {
        $logs = LogActivity::getUserActivityLog();
        return view('dashboard.admin.settings.viewLogs',compact('logs'));
    }
    public function createCharges(Request $request)
    {
        if($request->chargesID == ''){
            Charges::create([
                'name' => $request->name,
                'fees_amount' => $request->feesAmount,
            ]);
            LogActivity::logUserActivity('User Created Charges');
            $data = ['success' => true, 'message'=> 'Action successfully completed!.'];
            return response()->json($data);
        }else {
            Charges::where('id', $request->chargesID)->update([
                'name' => $request->name,
                'fees_amount' => $request->feesAmount,
            ]);
            LogActivity::logUserActivity('User Updated Charges');
            $data = ['success' => true, 'message'=> 'Action successfully completed!.'];
            return response()->json($data);
        }
    }

    public function destroyCharges(Request $request)
    {
        $deleteProduct = Charges::find($request->chargeID)->delete();
        if($deleteProduct){
            LogActivity::logUserActivity('User Deleted Charges');
            $data = ['warning' => true, 'message'=> 'Charge successfully deleted.'];
            return response()->json($data);
        }

    }

    public function showCreateDepartmentForm()
    {
        $departments = DepartmentAndZone::all();
        return view('dashboard.admin.settings.setUpDepartments',compact('departments'));
    }

    public function createDepartmentOrZone(Request $request)
    {
        if($request->departmentID == ''){
            $checkUniqueDepartment = DepartmentAndZone::where('name',$request->departName)->first();
            if($checkUniqueDepartment != null) {
                $data = ['warning' => true, 'message' => 'You cannot have duplicate departments. Department already exists.'];
                return response()->json($data);
            }else{
                DepartmentAndZone::create([
                    'name' => $request->departName,
                ]);
                LogActivity::logUserActivity('User Created Department');
                $data = ['success' => true, 'message'=> 'Action successfully completed!.'];
                return response()->json($data);
            }
        }else {
            $checkUniqueDepartment = DepartmentAndZone::where('id',$request->departmentID)->first();
            if($checkUniqueDepartment->name == $request->departName){
                $data = ['warning' => true, 'message'=> 'You cannot have duplicate departments. Department already exists.'];
                return response()->json($data);
            }else{
                DepartmentAndZone::where('id', $request->departmentID)->update([
                    'name' => $request->departName,
                ]);
                LogActivity::logUserActivity('User Updated Department');
                $data = ['success' => true, 'message'=> 'Action successfully completed!.'];
                return response()->json($data);
            }

        }
    }

    public function destroyDepartment(Request $request)
    {
        $deleteProduct = DepartmentAndZone::find($request->departmentID)->delete();
        if($deleteProduct){
            LogActivity::logUserActivity('User Deleted Department');
            $data = ['warning' => true, 'message'=> 'Department successfully deleted.'];
            return response()->json($data);
        }

    }

}
