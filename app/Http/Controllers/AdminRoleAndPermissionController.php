<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class AdminRoleAndPermissionController extends Controller
{
    //
    public function showRolePermissionForm()
    {
        $users = User::withoutTrashed()->where('name','!=','Administrator')->where('membership_status',1)->where('is_verified',1)
            ->select('id','name','user_role')->get();
        return view('dashboard.admin.config.configRolePermission',compact('users'));
    }

    public function assignUserRoleAndPermission(Request $request)
    {
        $assignRole = User::withoutTrashed()->where('id', $request->selectedUserID)->update([
            'user_role' => $request->selectedUserRole,
            'is_admin' => true,
        ]);
        if ($assignRole) {
            $data = ['success' => true, 'message' => "Role Successfully Assigned"];
            return response()->json($data);
        }
    }

    public function revokeRoleAndPermission(Request $request)
    {
        $assignRole = User::where('id', $request->userID)->update([
            'user_role' => Null,
            'is_admin' => false,
        ]);
        if ($assignRole) {
            $data = ['warning' => true, 'message' => "Role Successfully Revoked"];
            return response()->json($data);
        }


    }

}
