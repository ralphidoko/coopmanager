<?php

namespace App\Http\Livewire;

use App\Bank;
use App\Banktable;
use App\DepartmentAndZone;
use App\Http\Controllers\MailController;
use App\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Intervention\Image\ImageManagerStatic;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Member;
use Illuminate\Database\Eloquent\Collection;


class UpdateUserProfile extends Component
{

    public $image,$first_name,$middle_name,$last_name,$office_location,$staff_no,$department,$gender,
           $designation,$residential_address,$state_of_origin,$lga,$town,$nok_fname,$nok_mname,$nok_lname,
           $nok_tel,$nok_address,$nok_relationship,$bank_name,$account_no,$account_name,$passport,$referee_one,
           $referee_two,$certification;

    protected $listeners = ['fileUpload' => 'handleFileUpload'];

    //getting file from view
    public function handleFileUpload($imageData)
    {
       $this->image = $imageData;
       //dd($this->image);
    }
    public function storeImage()
    {
        if(!$this->image):
            return null;
        endif;
        $passport = User::where('id',Auth::id())->first()->passport_url;
        if($passport):
            Storage::delete('/public/' . $passport);
        endif;
        $img = ImageManagerStatic::make($this->image)->encode('jpg');
        $name = Str::random().'.jpg';
        Storage::disk('public')->put($name,$img);
        return $name;

    }
    private function resetFields()
    {
        $this->first_name = '';
        $this->middle_name = '';
        $this->last_name = '';
        $this->staff_no = '';
        $this->residential_address = '';
        $this->office_location = '';
        $this->department = '';
        $this->designation = '';
        $this->gender = '';
        $this->state_of_origin = '';
        $this->lga = '';
        $this->town = '';
        $this->nok_fname = '';
        $this->nok_mname = '';
        $this->nok_lname = '';
        $this->nok_address ='';
        $this->nok_tel = '';
        $this->nok_relationship = '';
        $this->image = "";
        $this->bank_name = '';
        $this->account_name = '';
        $this->account_no = '';
        $this->referee_one = '';
        $this->referee_two = '';
        $this->certification = '';
    }

    //real-time validation
    public function updated($field)
    {
        $this->validateOnly($field, ['first_name'=>'required']);
       // $this->validateOnly($field, ['middle_name'=>'required']);
        $this->validateOnly($field, ['last_name'=>'required']);
        $this->validateOnly($field, ['office_location'=>'required']);
        $this->validateOnly($field, ['staff_no'=>'required']);
        $this->validateOnly($field, ['department'=>'required']);
        $this->validateOnly($field, ['gender'=>'required']);
        $this->validateOnly($field, ['designation'=>'required']);
        $this->validateOnly($field, ['residential_address'=>'required']);
        $this->validateOnly($field, ['state_of_origin'=>'required']);
        $this->validateOnly($field, ['lga'=>'required']);
        $this->validateOnly($field, ['town'=>'required']);
        $this->validateOnly($field, ['nok_fname'=>'required']);
        $this->validateOnly($field, ['nok_lname'=>'required']);
        $this->validateOnly($field, ['nok_tel'=>'required|max:100|min:11']);
        $this->validateOnly($field, ['nok_address'=>'required']);
        $this->validateOnly($field, ['nok_relationship'=>'required']);
        $this->validateOnly($field, ['bank_name'=>'required']);
        $this->validateOnly($field, ['account_name'=>'required']);
        $this->validateOnly($field, ['account_no'=>'required|max:10|min:10']);
        $this->validateOnly($field, ['referee_one'=>'required']);
        $this->validateOnly($field, ['referee_two'=>'required']);
        $this->validateOnly($field, ['certification'=>'required']);
    }

    //adding comment and image to the db
    public function updateProfile()
    {
        $this->validate(['first_name'=>'required']);
        $this->validate(['last_name'=>'required']);
        $this->validate(['office_location'=>'required']);
        $this->validate(['staff_no'=>'required']);
        $this->validate(['department'=>'required']);
        $this->validate(['gender'=>'required']);
        $this->validate(['designation'=>'required']);
        $this->validate(['residential_address'=>'required']);
        $this->validate(['state_of_origin'=>'required']);
        //$this->validate(['lga'=>'required']);
        $this->validate(['town'=>'required']);
        $this->validate(['nok_fname'=>'required']);
        $this->validate(['nok_lname'=>'required']);
        $this->validate(['nok_tel'=>'required|max:100|min:11']);
        $this->validate(['nok_address'=>'required']);
        $this->validate(['nok_relationship'=>'required']);
        $this->validate(['bank_name'=>'required']);
        $this->validate(['account_name'=>'required']);
        $this->validate(['account_no'=>'required|max:10|min:10']);
        $this->validate(['referee_one'=>'required']);
        $this->validate(['referee_two'=>'required']);
        $this->validate(['certification'=>'required']);

        $image = $this->storeImage();//image function

        Member::where('user_id',Auth::user()->id)->update([
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'staff_no' => $this->staff_no,
            'residential_address' => $this->residential_address,
            'office_location' => $this->office_location,
            'department' => $this->department,
            'designation' => $this->designation,
            'gender' => $this->gender,
            'state_of_origin' => $this->state_of_origin,
            'lga' => $this->lga,
            'town' => $this->town,
            'nok_fname' => $this->nok_fname,
            'nok_mname' => $this->nok_mname,
            'nok_lname' => $this->nok_lname,
            'nok_address' => $this->nok_address,
            'nok_phone_number' => $this->nok_tel,
            'nok_relationship' => $this->nok_relationship,
            'referee_one' => $this->referee_one,
            'referee_two' => $this->referee_two,
            'certification' => $this->certification,
        ]);

        Bank::where('user_id',Auth::user()->id)->update([
            'bank_name' => $this->bank_name,
            'account_name' => $this->account_name,
            'account_no' => $this->account_no
        ]);

        User::where('id',Auth::id())->update([
            'passport_url' => $image,
        ]);

        $registeredUser = Auth::user();

        //send membership notification to admin
        (new MailController())->newRegistrationNotifyAdmin($registeredUser);

        $this->resetFields();
        \App\Helpers\LogActivity::logUserActivity(' User Updated Profile to Complete Registration');
        session()->flash('success',"Registration Successfully Completed. Please wait for EXCOs' approval!");
        redirect()->to('/dashboard/home');
    }

    public $user, $users,$banks,$member,$departments;

    public function mount()
    {
        $this->departments = DepartmentAndZone::all();
        $this->banks = Banktable::pluck('bank_name','id')->toArray();
        $this->user = User::where('id','!=',Auth::id())->where('name','!=','Administrator')->pluck('name','id')->toArray();
        $this->member = Member::where('user_id',Auth::id())->first();
    }

    public function render()
    {
        return view('livewire.update-user-profile');
    }
}
