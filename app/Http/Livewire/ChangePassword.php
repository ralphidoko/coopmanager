<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use App\User;

class ChangePassword extends Component
{
    public $old_password,$new_password,$c_password;

    //real-time validation
    public function updated($field)
    {
        $this->validateOnly($field, ['old_password'=>'required']);
        $this->validateOnly($field, ['new_password'=>'required']);
        $this->validateOnly($field, ['c_password'=>'required']);

    }

    public function changePassword()
    {
        $this->validate(['old_password'=>'required']);
        $this->validate(['new_password'=>'required']);
        $this->validate(['c_password'=>'required']);

        $user_password = User::where('id',Auth::id())->first()->password;
        $unveil_password = password_verify($this->old_password,$user_password);
        if($this->new_password != $this->c_password):
            return session()->flash('error','Confirm password does not match, try again');
        elseif($unveil_password != $this->old_password):
            return session()->flash('error','Old password does not match, please get it right');
        else:
            User::where('id',Auth::user()->id)->update([
            'password' => Hash::make($this->new_password),
        ]);
        endif;
        \App\Helpers\LogActivity::logUserActivity(' User Changed Password');
        session()->flash('success','Password changed successfully');
    }

    public function render()
    {
        return view('livewire.change-password');
    }
}
