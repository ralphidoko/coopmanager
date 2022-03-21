<?php

namespace App\Http\Controllers;
use App\Charges;
use App\Events\AccountClosureEvent;
use App\Events\offSetLoanBalanceEvent;
use App\Events\RecordUserTransactionsEvent;
use App\Events\RenewMembershipEvent;
use App\Events\SavingsWithdrawalEvent;
use App\Events\UpdateIncomeAndAuthorityToDeductPayEvent;
use App\Events\UpdateIncomeAndLoanEvent;
use App\Events\UpdateIncomeAndOtherDetailsEvent;
use App\Events\UpdateSavingsAccountEvent;
use App\User;
use Unicodeveloper\Paystack\Facades\Paystack;

class PaymentController extends Controller
{
    /**
     * Redirect the User to Paystack Payment Page
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function redirectToGateway()
    {
        $url = redirect()->back()->with('warning','The payment token has expired. Please refresh the page and try again.');
        try{
            return Paystack::getAuthorizationUrl()->redirectNow();
        }catch(\Exception $e) {
            return $url;
           // return Redirect::back()->withMessage(['msg'=>'The paystack token has expired. Please refresh the page and try again.', 'type'=>'error']);
        }
    }
    /**
     * Obtain Paystack payment information
     * @return int|string
     * @return User
     */
    public function handleGatewayCallback()
    {
        //if (Auth::check()) {
            $paymentDetails = Paystack::getPaymentData();
            //dd($paymentDetails);
            if ($paymentDetails['status'] == true) {
                $date = $paymentDetails['data']['transaction_date'];
                $newDate = date('Y-m-d', strtotime($date));
                //this excludes membership renewal because users are not authenticated
                if($paymentDetails['data']['metadata'][0] != 'membership_renewal'){
                    $user = User::where('email', $paymentDetails['data']['customer']['email'])->first();
                    $user_id = $user->id;$user_name = $user->name;
                }

                //$service_type = null;
                if(is_numeric($paymentDetails['data']['metadata'][0])){
                    $serviceType = Charges::where('id', $paymentDetails['data']['metadata'][0])->first();
                    $service_type = $serviceType->name;
                    $coopFees = $serviceType->fees_amount;
                }elseif($paymentDetails['data']['metadata'][0] == 'extra_deposit'){
                    $service_type = 'extra_deposit';
                }elseif($paymentDetails['data']['metadata'][0] == 'loan_balance'){
                    $service_type = 'loan_balance';
                }elseif($paymentDetails['data']['metadata'][0] == 'membership_renewal'){
                    $serviceType = Charges::where('id', $paymentDetails['data']['metadata'][0])->first();
                    $service_type = 'membership_renewal';
                    $coopFees = $serviceType->fees_amount;
                }

                //create transaction details
                if ($service_type == 'Membership Registration Fees'):
                    $transaction_type = 'Membership Registration Fees';
                    event(new RecordUserTransactionsEvent($paymentDetails,$user_id,$newDate,$transaction_type,$coopFees));
                    event(new UpdateIncomeAndOtherDetailsEvent($paymentDetails,$user_id,$transaction_type,$coopFees));
                    //notify the user of account activation
                    $emailContents = [
                        'transaction_amount' =>  $coopFees,
                        'transaction_reference' => $paymentDetails['data']['reference'],
                        'name' => $user_name,
                    ];
                    (new MailController)->accountActivationNotification($emailContents, $paymentDetails);
                    \App\Helpers\LogActivity::logUserActivity(' User Paid Membership Registration Fees');
                    return redirect('/UpdateUserProfile')->with('success', 'Your account has been activated, you can now complete your registration');

                elseif($service_type == 'Loan Application Fees'):
                    $transaction_type = 'Loan Application Fees';
                    event(new RecordUserTransactionsEvent($paymentDetails,$user_id,$newDate,$transaction_type,$coopFees));
                    event(new UpdateIncomeAndLoanEvent($paymentDetails,$user_id,$coopFees,$transaction_type));
                    \App\Helpers\LogActivity::logUserActivity(' User Paid Loan Application Fees');
                    return redirect('/dashboard/home')->with('success', 'Payment successful, you can now proceed with your application.');

                elseif($service_type == 'Authority to Deduct Pay'):
                    $transaction_type = 'Authority to Deduct Pay';
                    event(new RecordUserTransactionsEvent($paymentDetails,$user_id,$newDate,$transaction_type,$coopFees));
                    event(new UpdateIncomeAndAuthorityToDeductPayEvent($paymentDetails,$user_id,$coopFees));
                    \App\Helpers\LogActivity::logUserActivity(' User Paid Authority to Deduct Pay Fees');
                    return redirect('/dashboard/home')->with('success', 'Payment successful, you can now proceed with your authorization.');

                elseif($service_type == 'Savings/Withdrawal Fees'):
                    $transaction_type = 'Savings/Withdrawal Fees';
                    event(new RecordUserTransactionsEvent($paymentDetails,$user_id,$newDate,$transaction_type,$coopFees));
                    event(new SavingsWithdrawalEvent($user_id,$coopFees,$transaction_type,$newDate));
                    \App\Helpers\LogActivity::logUserActivity(' User Paid Savings Withdrawal Fees');
                    return redirect('/withdrawals/makeWithdrawal')->with('success', 'Payment successful, you can now proceed with your request.');

                elseif($service_type == 'Account Closure Fees'):
                    $transaction_type = 'Account Closure Fees';
                    event(new RecordUserTransactionsEvent($paymentDetails,$user_id,$newDate,$transaction_type,$coopFees));
                    event(new AccountClosureEvent($user_id,$coopFees,$transaction_type));
                    \App\Helpers\LogActivity::logUserActivity(' User Paid Account Closure Fees');
                    return redirect('/dashboard/accountClosure');

                elseif($paymentDetails['data']['metadata'][0] == 'loan_balance'):
                    $paymentData = $paymentDetails;
                    $transaction_type = 'Payment of Loan Balance';
                    event(new offSetLoanBalanceEvent($paymentData,$coopFees));
                    event(new RecordUserTransactionsEvent($paymentDetails,$user_id,$newDate,$transaction_type,$coopFees));
                    \App\Helpers\LogActivity::logUserActivity(' User Paid Loan Balance');
                    return redirect('/application/loanList')->with('success', 'You have successfully offset your outstanding loan balance');

                elseif($paymentDetails['data']['metadata'][0] == 'extra_deposit'):
                    $transaction_type = 'Extra Savings';
                    event(new UpdateSavingsAccountEvent($paymentDetails,$user_id,$newDate,$transaction_type));
                    \App\Helpers\LogActivity::logUserActivity(' User Made  Extra Deposits');
                    return redirect('/dashboard/home')->with('success', 'Your extra deposit has been successfully recorded.');

                elseif($paymentDetails['data']['metadata'][1] == 'membership_renewal'):
                    $transaction_type = 'Membership Renewal Fees';
                    $user_id = $paymentDetails['data']['metadata'][2];
                    event(new RecordUserTransactionsEvent($paymentDetails,$user_id,$newDate,$transaction_type,$coopFees));
                    event(new RenewMembershipEvent($user_id,$transaction_type,$coopFees,$paymentDetails));
                    (new MailController)->membershipRenewalNotification($paymentDetails);
                    //\App\Helpers\LogActivity::logUserActivity(' User Paid Membership Renewal Fees',$user_id);
                    return redirect('/login')->with('success', 'Request submitted, you can now login to your account.');
                endif;

            } else {
                //what should happen if payment failed from paystack
                return $this->redirectToGateway();
            }

        //}else{
            connection_aborted();
        //}
    }


}
