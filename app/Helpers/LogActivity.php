<?php
namespace App\Helpers;
use App\LogActivity as LogActivityModel;
use Illuminate\Support\Facades\Auth;

class LogActivity
{

    public static function logUserActivity($actionPerformed)
    {
        LogActivityModel::create([
            'action_performed' => $actionPerformed,
            'user_id' => Auth::id(),
            'url' => \Illuminate\Support\Facades\Request::fullUrl(),
            'method' => \Illuminate\Support\Facades\Request::method(),
            'ip_address' => \Illuminate\Support\Facades\Request::ip(),
            'user_agent' => \Illuminate\Support\Facades\Request::header('user_agent'),
        ]);

    }

    public static function getUserActivityLog()
    {
       return LogActivityModel::all()->sortByDesc('id');

    }


}
