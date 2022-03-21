<?php

namespace App\Http\Controllers;

use App\Mail\AccountActivated;
use App\Mail\authorityToPayApprovalNotification;
use App\Mail\DecreaseSavingNotifyExcos;
use App\Mail\DecreaseSavingSubmission;
use App\Mail\IncreaseSavingNotifyExcos;
use App\Mail\IncreaseSavingSubmission;
use App\Mail\InstallmentPaymentNotification;
use App\Mail\loanApplicationApproved;
use App\Mail\loanApplicationRejected;
use App\Mail\membershipApprovalNotifyMember;
use App\Mail\membershipRejectionNotifyMember;
use App\Mail\MembershipRenewalNotification;
use App\Mail\NewRegistrationNotifyAdmin;
use App\Mail\SavingsWithdrawalApprovalNotifyMember;
use App\Mail\SavingWithdrawalNotification;
use App\Mail\SavingWithdrawalNotifyExcos;
use App\Mail\SendEmailVerification;
use App\User;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{

    public function accountActivationNotification($emailContents,$paymentDetails)
    {
        Mail::to($paymentDetails['data']['customer']['email'])->send((new AccountActivated($emailContents)));
    }

    public function submitIncreaseSaving($deduction_details)
    {
        //notify the applicant
        Mail::to($deduction_details['user_email'])->send((new IncreaseSavingSubmission($deduction_details)));
        //notify all the admin
        foreach ($deduction_details['admin_email'] as $admin_email){
            Mail::to($admin_email)->send((new IncreaseSavingNotifyExcos($deduction_details)));
        }
    }

     public function submitDecreaseSaving($deduction_details)
     {
        //notify the applicant
        Mail::to($deduction_details['user_email'])->send((new DecreaseSavingSubmission($deduction_details)));
        //notify all the admin
        foreach ($deduction_details['admin_email'] as $admin_email){
            Mail::to($admin_email)->send((new DecreaseSavingNotifyExcos($deduction_details)));
        }
     }

     public function loanApplicationRejectionNotification($rejection_details)
     {
         //notify the applicant of rejection
         Mail::to($rejection_details['email'])->send((new loanApplicationRejected($rejection_details)));
     }

    public function loanApplicationApprovalNotification($approval_details)
    {
        //notify the applicant of application approval
        Mail::to($approval_details['email'])->send((new loanApplicationApproved($approval_details)));
    }

    public function submitSavingWithdrawalRequest($withdrawal_details)
    {
        //notify the applicant
        Mail::to($withdrawal_details['user_email'])->send((new SavingWithdrawalNotification($withdrawal_details)));
        //notify all the admin
        foreach ($withdrawal_details['admin_email'] as $admin_email){
            Mail::to($admin_email)->send((new SavingWithdrawalNotifyExcos($withdrawal_details)));
        }

    }

    public function authorityToDeductPayApprovalNotification($deduct_pay_approval)
    {
        //notify all the members
        foreach ($deduct_pay_approval['user_email'] as $user_email){
            Mail::to($user_email)->send((new authorityToPayApprovalNotification($deduct_pay_approval)));
        }
    }

    public function savingsWithdrawalApprovalNotifyMember($withdrawal_details)
    {
        //notify the applicant
        Mail::to($withdrawal_details['user_email'])->send((new SavingsWithdrawalApprovalNotifyMember($withdrawal_details)));
    }

    public static function SendEmailVerification($usersDetails)
    {
        //send verification email
        Mail::to($usersDetails['email'])->send((new SendEmailVerification($usersDetails)));
    }

    public function membershipApprovalNotifyMember($applicationDetails)
    {
        Mail::to($applicationDetails['user_email'])->send((new membershipApprovalNotifyMember($applicationDetails)));
    }
    public  function membershipApplicationRejectionNotification($rejectionDetails)
    {
        Mail::to($rejectionDetails['user_email'])->send((new membershipRejectionNotifyMember($rejectionDetails)));
    }

    public function membershipRenewalNotification($paymentDetails)
    {
        Mail::to($paymentDetails['data']['customer']['email'])->send((new MembershipRenewalNotification($paymentDetails)));
    }

    public function installmentPaymentNotification($installmentDetails)
    {
        Mail::to($installmentDetails['email'])->send((new InstallmentPaymentNotification($installmentDetails)));
    }

    public function newRegistrationNotifyAdmin($registeredUser)
    {
        Mail::to($registeredUser->email)->send((new NewRegistrationNotifyAdmin($registeredUser)));
    }


}
