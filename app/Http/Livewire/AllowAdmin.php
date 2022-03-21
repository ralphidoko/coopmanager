<?php

namespace App\Http\Livewire;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class AllowAdmin extends Component
{
    public $password;

    //real-time validation
    public function updated($field)
    {
        $this->validateOnly($field, ['password'=>'required']);

    }

    public function grantAdminAccess()
    {
        $this->validate(['password'=>'required']);

        $user_password = User::where('id',Auth::id())->first()->password;
        $unveil_password = password_verify($this->password,$user_password);

        if($unveil_password == $this->password):
            \App\Helpers\LogActivity::logUserActivity(' User Logged in as an Admin');
            return  redirect()->to('/dashboard/admin/adminHome');
        else:
            return session()->flash('error','Wrong password entered, please try again');
        endif;
    }

    public function render()
    {
        return view('livewire.allow-admin');
    }
}
