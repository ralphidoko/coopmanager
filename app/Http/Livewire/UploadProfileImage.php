<?php

namespace App\Http\Livewire;

use App\Bank;
use App\Http\Controllers\MailController;
use App\Member;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic;
use Livewire\Component;

class UploadProfileImage extends Component
{
    public $passport, $image;

    protected $listeners = ['fileUpload' => 'handleFileUpload'];

    //getting file from view
    public function handleFileUpload($imageData)
    {
        $this->image = $imageData;
        $image = $this->storeImage();//image function
        User::where('id',Auth::id())->update([
            'passport_url' => $image,
        ]);
        \App\Helpers\LogActivity::logUserActivity(' User Updated Profile Image');
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

    public function render()
    {
        return view('livewire.upload-profile-image');
    }
}
