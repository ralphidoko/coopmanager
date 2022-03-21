<?php

namespace App\Http\Controllers\Auth;

use App\Bank;
use App\Events\CreateMemberAndBankTemplateEvent;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MailController;
use App\Providers\RouteServiceProvider;
use App\User;
use App\Member;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    //protected $redirectTo = RouteServiceProvider::HOME;
    //protected $redirectTo = RouteServiceProvider::PAY;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
//    public function __construct()
//    {
//        $this->middleware('guest');
//    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'ippis_no' => ['required','string','unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone_no' => ['required', 'string', 'min:11','max:11'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \Illuminate\Http\RedirectResponse
     * @return \App\Bank
     */
    public function register(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->ippis_no = $request->ippis_no;
        $user->phone_no = $request->phone_no;
        $user->password = Hash::make($request->password);
        $user->verification_code = sha1(time());
        $user->save();

        $usersDetails = $user;

        if($user != null){

            event(new CreateMemberAndBankTemplateEvent($usersDetails));

            MailController::SendEmailVerification($usersDetails);

            return redirect()->back()->with('success','We have sent you an email verification link. Please verify your email to continue.');

        }else{
            return redirect()->route('/register')->with('warning','Something went wrong during registration.');
        }

    }

    public function VerifyUserEmail(Request $request)
    {
        $verification_code = \Illuminate\Support\Facades\Request::get('code');
        $user = User::where(['verification_code'=>$verification_code])->first();
            if($user != null){
                $user->is_verified = 1;
                $user->save();
                return redirect('/login')->with('success','Please login to continue your registration process.');
            }else{
                return redirect()->route('/register')->with('warning','Invalid verification code.');
            }
    }

}
