<?php

namespace App\Http\Controllers;

use App\AuthorityToDeductPay;
use App\Events\AuthorityToDeductPayMailEvent;
use App\Saving;
use App\SavingAuthorization;
use App\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\DocBlock\Tags\Reference\Url;

class SavingController extends Controller
{

    public function showAuthorizationForm()
    {
        //$checkExistingSaving = DB::Table('authority_to_deduct_pays')->where('user_id',Auth::id())->exists();
        //if($checkExistingSaving == true):
            return $this->renderSavingAuthForm();
       // else:
         //   return redirect('/accountActivation/makePayment');
        //endif;
    }

    private function renderSavingAuthForm()
    {
        if(isset($_SERVER['HTTP_REFERER'])):
            $current_saving = AuthorityToDeductPay::where('user_id',Auth::user()->id)->first();
            return view('dashboard.savings.savingStandingOrder',compact('current_saving'));
        else:
            return redirect('/dashboard/home');
        endif;
    }

    public function submitSavingAuthorization(Request $request)
      {
          if(Auth::check()){
              if($request->auth_type != null):
                  if($request->auth_type == 1):
                      $validator = request()->validate([
                          'current_amount' => 'required',
                          'desired_amount' => 'required',
                          'start_date' => 'required',
                      ]);
                      if(!in_array('message',$validator)){
                          return $this->handleIncreaseSavings($request);
                      }else {
                          return response()->json();
                      }
                  elseif($request->auth_type == 2):
                      $validator = request()->validate([
                          'current_amount' => 'required',
                          'desired_amount' => 'required',
                          'start_date' => 'required',
                      ]);
                      if(!in_array('message',$validator)){
                          return $this->handleDecreaseSavings($request);
                      }else {
                          return response()->json();
                      }
                  elseif ($request->auth_type == 3):
                      $validator = request()->validate([
                          'authorized_amount' => 'required',
                          'start_date' => 'required',
                      ]);
                      if(!in_array('message',$validator)){
                          return $this->createAuthorityToDeductPay($request);
                      }else {
                          return response()->json();
                      }
                  endif;
              endif;
          }
      }

    public function showSavingAuthorizationList()
    {
        $auth_lists = SavingAuthorization::where('user_id',Auth::id())->orderBy('created_at','desc')->get();
        $deductions = AuthorityToDeductPay::where([['user_id','=',Auth::id()],['authorized_amount','!=',0.00]])->orderBy('created_at','desc')->get();
        \App\Helpers\LogActivity::logUserActivity(' User Viewed List of Authorizations');
        return view('dashboard.savings.showSavingAuthorizationList',compact('auth_lists','deductions'));
    }

    private function handleIncreaseSavings(Request $request,$allowed_interval=30)
    {
        //restrict user from submitting multiple requests within a month
        $date_of_approval = null;
        $_date_of_approval = DB::table('saving_authorizations')->select(DB::raw('DATE(updated_at) As approval_date'),'status')
            ->where('user_id',Auth::id())->orderByDesc('id')->first();
        if($_date_of_approval !== null){
            $date_of_approval = Carbon::parse($_date_of_approval->approval_date);
            $current_date = date('Y-m-d');
            $current_date = Carbon::parse($current_date);
            $difference = $date_of_approval->diffInDays($current_date);
        }
          //check whether the user has existing saving
          $check_existing_saving = Saving::where('user_id',Auth::id())->exists();

        //check to be sure that total saving is not equal to zero
          $total_saving = Saving::where('user_id',Auth::id())->sum('amount_saved');
          $desired_amount = str_replace(',','',$request->desired_amount);
          $current_amount = str_replace(',','',$request->current_amount);

          if($check_existing_saving != false){
              if($total_saving != 0.00){
                   if(!($desired_amount <= $current_amount)){
                       if($date_of_approval !== null && !($difference >= $allowed_interval)){
                           $data = ['warning' => true, 'message'=> 'You cannot submit multiple requests within a month.
                                    Please, wait for another month or delete the current one instead'];
                           return response()->json($data);
                       }else{
                           //submit authorization
                           SavingAuthorization::create([
                               'user_id' => Auth::id(),
                               'current_amount' => $current_amount,
                               'desired_amount' => $desired_amount,
                               'auth_type' => $request->auth_type,
                               'auth_text' => $request->auth_text,
                               'start_date' => $request->start_date,
                           ]);

                           //increase saving notification
                           $user_object = User::where('id', Auth::id())->first();
                           $admin_email = User::where('is_admin', true)->pluck('email')->all();//collect emails of all admin users
                           $deduction_details = [
                               'user_email' => $user_object->email,
                               'user_name' => $user_object->name,
                               'admin_email' => $admin_email,
                               'current_amount' => $current_amount,
                               'desired_amount' => $desired_amount,
                               'auth_text' => $request->auth_text,
                               'start_date' => $request->start_date,
                           ];
                           (new MailController)->submitIncreaseSaving($deduction_details);
                           \App\Helpers\LogActivity::logUserActivity(' User Submitted Request to Increase Monthly Savings');
                           session()->flash('success', "Your saving increment authorization has been received!");
                           return response()->json(['url' => url('/savings/savingAuthorizationList')]);
                       }

                   }else{
                       $data = ['warning' => true, 'message'=> 'Sorry, amount to deduct must be greater than the current amount! '];
                       return response()->json($data);
                   }
              //send notification to user
              }else{
                  $data = ['warning' => true, 'message'=> 'Sorry, you currently do not have any saving, try making making some deposits! '];
                  return response()->json($data);
              }
          }else{
              $data = ['warning' => true, 'message'=> 'Sorry, you need to have an existing saving in order to authorize increase or decrease deduction'];
              return response()->json($data);
          }
    }

    private function handleDecreaseSavings(Request $request,$allowed_interval=30)
    {
        //restrict user from submitting multiple request within a month
        $date_of_approval = null;
        $_date_of_approval = DB::table('saving_authorizations')->select(DB::raw('DATE(updated_at) As approval_date'),'status')
            ->where('user_id',Auth::id())->orderByDesc('id')->first();
        if($_date_of_approval !== null) {
            $date_of_approval = Carbon::parse($_date_of_approval->approval_date);
            $current_date = date('Y-m-d');
            $current_date = Carbon::parse($current_date);
            $difference = $date_of_approval->diffInDays($current_date);
        }

        $check_existing_saving = Saving::where('user_id',Auth::id())->exists();
        //check to be sure total saving is not equal to zero
        $total_saving = Saving::where('user_id',Auth::id())->sum('amount_saved');
        $desired_amount = str_replace(',','',$request->desired_amount);
        $current_amount = str_replace(',','',$request->current_amount);
        if($check_existing_saving != false){
            if($total_saving != 0){
                if (!($desired_amount >= $current_amount)) {
                    if($date_of_approval !== null && !($difference >= $allowed_interval)){
                        $data = ['warning' => true, 'message'=> 'You cannot submit multiple requests within a month.
                                    Please, wait for another month or delete the current one instead'];
                        return response()->json($data);
                    }else {
                        //submit authorization
                        SavingAuthorization::create([
                            'user_id' => Auth::id(),
                            'current_amount' => $current_amount,
                            'desired_amount' => $desired_amount,
                            'auth_type' => $request->auth_type,
                            'auth_text' => $request->auth_text,
                            'start_date' => $request->start_date,
                        ]);

                        //decrease saving notification
                        $user_details = User::where('id', Auth::id())->first();
                        $admin_email = User::where('is_admin', true)->pluck('email')->all();//collect emails of all admin users
                        $deduction_details = [
                            'user_email' => $user_details->email,
                            'user_name' => $user_details->name,
                            'admin_email' => $admin_email,
                            'desired_amount' => $desired_amount,
                            'current_amount' => $current_amount,
                            'auth_text' => $request->auth_text,
                            'start_date' => $request->start_date,
                        ];
                        (new MailController)->submitDecreaseSaving($deduction_details);
                        \App\Helpers\LogActivity::logUserActivity(' User Submitted Request to Decrease Monthly Savings');
                        session()->flash('success', "Your saving increment authorization has been received!");
                        return response()->json(['url' => url('/savings/savingAuthorizationList')]);
                    }

                } else {
                    $data = ['warning' => true, 'message' => 'Sorry, amount to reduce must be less than the current saving! '];
                    return response()->json($data);
                }
            }else{
                $data = ['warning' => true, 'message'=> 'Sorry, you currently do not have any saving, try making making some deposits! '];
                return response()->json($data);
            }
        }else{
            $data = ['warning' => true, 'message'=> 'Sorry, you currently do not have any saving, try making making some deposits! '];
            return response()->json($data);

        }

    }

    private function createAuthorityToDeductPay(Request $request)
    {
          $check_existing_auth = AuthorityToDeductPay::where('user_id', Auth::id())->first();
          if ($check_existing_auth->status == 'Awaiting Approval') {
              $authorized_amount = str_replace(',','',$request->authorized_amount);
              AuthorityToDeductPay::where('user_id',Auth::id())->update([
                    'authorized_amount' => $authorized_amount,
                    'start_date' => $request->start_date,
                    'certification' =>$request->certify,
                ]);

              //pay deduction notification
              $user_name = User::where('id',Auth::id())->firstOrFail()->name;
              $user_email = User::where('id',Auth::id())->firstOrFail()->email;
              $admin_email = User::where('is_admin',true)->pluck('email')->all();//collect emails of all admin users
              $deduction_details = [
                  'user_email' => $user_email,
                  'user_name' => $user_name,
                  'admin_email' => $admin_email,
                  'authorized_amount' => $authorized_amount,
                  'start_date' => $request->start_date,
              ];

              //this event notifies user and admin
              event(new AuthorityToDeductPayMailEvent($deduction_details));
              \App\Helpers\LogActivity::logUserActivity(' User Submitted Request for Authority to Deduct Pay ');
                session()->flash('success', "Your authorization to deduct pay has been submitted!");
                return response()->json(['url' => url('/savings/savingAuthorizationList')]);
          }else{
              $data = ['warning' => true, 'message'=> 'Sorry, you cannot create multiple authorizations, one already exists!'];
              return response()->json($data);
          }
    }

    public function deleteSavingAuthorization (Request $request)
    {
        if (Auth::check()) {
            if ($request->auth_type == 1) {
                SavingAuthorization::where([['user_id', '=', Auth::id()], ['status', '=', 'Awaiting Approval']])->delete();
                session()->flash('success', 'Authorization Successfully deleted!');
                return response()->json(['url' => url('/savings/savingAuthorizationList')]);
            } else if ($request->auth_type == 2) {
                SavingAuthorization::where([['user_id', '=', Auth::id()], ['status', '=', 'Awaiting Approval']])->delete();
                session()->flash('success', 'Authorization Successfully deleted!');
                return response()->json(['url' => url('/savings/savingAuthorizationList')]);
            }
            \App\Helpers\LogActivity::logUserActivity(' User Deleted Savings Authorization');

        }
    }

    public function deleteAuthorityDeductToPay (Request $request)
    {
        if(Auth::check()){
            AuthorityToDeductPay::find($request->loan_id)->delete();
            \App\Helpers\LogActivity::logUserActivity(' User Deleted Authority to Deduct pay');
            session()->flash('success','Standing Order Successfully deleted!');
            return response()->json(['url'=>url('/savings/savingAuthorizationList')]);
        }else{
            Auth::logout();
        }

    }

    public function showAuthorizationDetail($loan_id)
    {
        if(Auth::check()) {
            $current_saving = AuthorityToDeductPay::where('user_id', Auth::id())->first();
            $auth_details = SavingAuthorization::where('id',$loan_id)->firstOrFail();
            return view('dashboard.savings.updateAuthorization',compact('auth_details','current_saving'));
        }else{
            Auth::logout();
        }
    }

    public function updateAuthorization(Request $request)
    {
        if(Auth::check()){
            if($request->auth_type != null):
                if($request->auth_type == 1):
                    $validator = request()->validate([
                        'applicant' => 'required',
                        'current_amount' => 'required',
                        'desired_amount' => 'required',
                        'start_date' => 'required',
                    ]);
                    if(!in_array('message',$validator)){
                        return $this->updateIncreaseSavings($request);
                    }else {
                        return response()->json();
                    }
                elseif($request->auth_type == 2):
                    $validator = request()->validate([
                        'applicant' => 'required',
                        'current_amount' => 'required',
                        'desired_amount' => 'required',
                        'start_date' => 'required',
                    ]);
                    if(!in_array('message',$validator)){
                        return $this->updateDecreaseSavings($request);
                    }else {
                        return response()->json();
                    }
                elseif ($request->auth_type == 3):
                    $validator = request()->validate([
                        'applicant' => 'required',
                        'authorized_amount' => 'required',
                        'start_date' => 'required',
                    ]);
                    if(!in_array('message',$validator)){
                        return $this->createAuthorityToDeductPay($request);
                    }else {
                        return response()->json();
                    }
                endif;
            endif;
        }else{
            Auth::logout();
        }
    }

    private function updateIncreaseSavings($request){
            //check to be sure total saving is not equal to zero
        $total_saving = Saving::where('user_id',Auth::id())->sum('amount_saved');
        $desired_amount = str_replace(',','',$request->desired_amount);
        $current_amount = str_replace(',','',$request->current_amount);

            if($total_saving != 0){
                if(!($desired_amount <= $current_amount)){
                    //submit authorization
                    SavingAuthorization::where('id', $request->auth_id)->update([
                        'current_amount' => $current_amount, //update the current amount with desired amount when approved
                        'desired_amount' => $desired_amount,
                        'auth_type' => $request->auth_type,
                        'auth_text' => $request->auth_text,
                        'start_date' => $request->start_date,
                    ]);
                    \App\Helpers\LogActivity::logUserActivity(' User Updated Increase Saving Authorization');
                    session()->flash('success',"Authorization Successfully Updated!");
                    return response()->json(['url'=>url('/savings/savingAuthorizationList')]);
                }else{
                    $data = ['warning' => true, 'message'=> 'Sorry, amount to deduct must be greater than the current amount! '];
                    return response()->json($data);
                }
                //send notification to user
            }else{
                $data = ['warning' => true, 'message'=> 'Sorry, you currently do not have any saving, try making making some deposits! '];
                return response()->json($data);
            }

    }

    private function updateDecreaseSavings($request){
            //check to be sure total saving is not equal to zero
        $total_saving = Saving::where('user_id',Auth::id())->sum('amount_saved');
        $desired_amount = str_replace(',','',$request->desired_amount);
        $current_amount = str_replace(',','',$request->current_amount);

            if($total_saving != 0){
                if(!($desired_amount >= $current_amount)){
                    //submit authorization
                    SavingAuthorization::where('id', $request->auth_id)->update([
                        'current_amount' => $current_amount, //update the current amount with desired amount when approved
                        'desired_amount' => $desired_amount,
                        'auth_type' => $request->auth_type,
                        'auth_text' => $request->auth_text,
                        'start_date' => $request->start_date,
                    ]);

                    \App\Helpers\LogActivity::logUserActivity(' User Updated Decrease Saving Authorization');
                    session()->flash('success',"Authorization Successfully Updated!");
                    return response()->json(['url'=>url('/savings/savingAuthorizationList')]);
                }else{
                    $data = ['warning' => true, 'message'=> 'Sorry, your current saving must be greater than amount to reduce! '];
                    return response()->json($data);
                }
                //send notification to user
            }else{
                $data = ['warning' => true, 'message'=> 'Sorry, you currently do not have any saving, try making making some deposits! '];
                return response()->json($data);
            }

    }

}
