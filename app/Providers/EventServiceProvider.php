<?php

namespace App\Providers;

use App\Events\AccountClosureEvent;
use App\Events\AuthorityToDeductPayMailEvent;
use App\Events\CreateMemberAndBankTemplateEvent;
use App\Events\LoanApplicationSubmissionMailEvent;
use App\Events\offSetLoanBalanceEvent;
use App\Events\RecordUserTransactionsEvent;
use App\Events\RenewMembershipEvent;
use App\Events\SavingsWithdrawalEvent;
use App\Events\UpdateApplicationStatusEvent;
use App\Events\UpdateIncomeAndAuthorityToDeductPayEvent;
use App\Events\UpdateIncomeAndLoanEvent;
use App\Events\UpdateIncomeAndOtherDetailsEvent;
use App\Events\UpdateSavingsAccountEvent;
use App\Listeners\AuthorityToDeductPayMailListener;
use App\Listeners\CreateLoanApplicationBoilerRecordListener;
use App\Listeners\CreateMemberAndBankListener;
use App\Listeners\LoanApplicationSubmissionListener;
use App\Listeners\offSetLoanBalanceListener;
use App\Listeners\RecordUserTransactionsListener;
use App\Listeners\RenewMembershipListener;
use App\Listeners\SavingsWithdrawalListener;
use App\Listeners\UpdateApplicationStatusListener;
use App\Listeners\UpdateIncomeAndAuthorityToDeductPayListener;
use App\Listeners\UpdateIncomeTableForAccountClosure;
use App\Listeners\UpdateIncomeTableForLoanApplication;
use App\Listeners\UpdateIncomeTableListener;
use App\Listeners\UpdateSavingsAccountListener;
use App\Listeners\UpdateUserTableListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        //custom events
        CreateMemberAndBankTemplateEvent::class => [
            CreateMemberAndBankListener::class,
        ],

        UpdateIncomeAndOtherDetailsEvent::class => [
            UpdateIncomeTableListener::class,
            UpdateUserTableListener::class,
        ],

        //this is triggered when extra deposit is made
        UpdateSavingsAccountEvent::class => [
            UpdateSavingsAccountListener::class,
        ],

        //this is triggered when savings withdrawal fees is paid
        SavingsWithdrawalEvent::class => [
            SavingsWithdrawalListener::class,
        ],
        //this is invoked when application fees is received
        UpdateIncomeAndLoanEvent::class => [
            UpdateIncomeTableForLoanApplication::class,
            CreateLoanApplicationBoilerRecordListener::class,
        ],

        //this is invoked when membership account is closed
        AccountClosureEvent::class => [
            UpdateIncomeTableForAccountClosure::class
        ],

        //this is invoked when membership is renewed
        RenewMembershipEvent::class => [
            RenewMembershipListener::class
        ],

        //this is triggered when user performs transaction
        RecordUserTransactionsEvent::class => [
            RecordUserTransactionsListener::class
        ],

        //this is invoked when payment for authority to deduct pay is received
        UpdateIncomeAndAuthorityToDeductPayEvent::class => [
            UpdateIncomeAndAuthorityToDeductPayListener::class,
        ],

        //this is invoked when application is submitted
        UpdateApplicationStatusEvent::class => [
            UpdateApplicationStatusListener::class
        ],

        LoanApplicationSubmissionMailEvent::class => [
            LoanApplicationSubmissionListener::class
        ],
        AuthorityToDeductPayMailEvent::class => [
            AuthorityToDeductPayMailListener::class
        ],
        //loan balance payment event
        offSetLoanBalanceEvent::class =>[
            offSetLoanBalanceListener::class
        ]

    ];

//    public function shouldDiscoverEvents()
//    {
//        return true;
//    }

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
