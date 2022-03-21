<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/cache-clear', function () {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:cache');
    return 'Done';
});

Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::get('/new_login','NewLoginController@showNewLogin');//not working
Route::get('/returningMember','NewLoginController@returningMemberLogin');
Route::POST('/renewMembership','NewLoginController@renewMembership');
Route::get('/accountActivation/membershipRenewal', 'NewLoginController@displayMembershipRenewalPaymentForm');


Route::post('/pay', 'PaymentController@redirectToGateway')->name('pay');//paystack essential
Route::get('/payment/callback', 'PaymentController@handleGatewayCallback');//paystack essential
//email verification link
Route::get('/emailVerification/verify','Auth\RegisterController@VerifyUserEmail');

Auth::routes();
Route::middleware(['auth'])->group(function(){
    Route::get('/home', 'HomeController@renderHomeDashboard')->name('home');

    Route::get('/dashboard/home', 'HomeController@renderHomeDashboard');

    Route::get('/accountClosure','AccountClosureController@closeUserAccount');

    Route::get('/dashboard/offSetLoanBalance/{loan_id}','LoanApplicationController@payOutStandingLoanBalance');

    Route::get('/dashboard/accountClosure','AccountClosureController@showAccountClosureSuccess');

    Route::get('/UpdateUserProfile', 'UpdateUserProfile@showUserData')->name('profile');

    Route::get('/application/loanApplication', 'LoanApplicationController@checkApplicationStatus');

    Route::delete('/deleteApplication', 'LoanApplicationController@deleteLoanApplication')->name('destroy');

    Route::get('/application/loanList', 'LoanApplicationController@showAvailableLoan');

    Route::get('/application/loanDetails/{loan_id}', 'LoanApplicationController@viewLoanDetailAndInstallments');

    Route::get('/application/{loan_id}/updateLoan', 'LoanApplicationController@showLoanDetail');

    Route::Post('/handleLoanUpdate','LoanApplicationController@updateLoan');

    Route::get('/savings/savingStandingOrder','SavingController@showAuthorizationForm');

    Route::Post('/handleSavingAuthorization','SavingController@submitSavingAuthorization');

    Route::get('/savings/savingAuthorizationList', 'SavingController@showSavingAuthorizationList');

    Route::Post('/getItemPrice','LoanApplicationController@getItemPrice');

    Route::get('/accountActivation/makePayment', 'ShowPaymentFormController@index')->name('payment');

    Route::delete('/deleteAuthorization', 'SavingController@deleteSavingAuthorization');

    Route::delete('/deleteAuthorityDeductToPay','SavingController@deleteAuthorityDeductToPay');

    Route::Post('/handleAuthorizationUpdate','SavingController@updateAuthorization');

    Route::get('/savings/{loan_id}/updateAuthorization', 'SavingController@showAuthorizationDetail');

    Route::get('/withdrawals/makeWithdrawal', 'SavingsWithdrawalController@checkSavingsWithdrawalPaymentStatus');

    Route::get('/withdrawals/withdrawalTransactions', 'SavingsWithdrawalController@showSavingsWithdrawalsTransactions');

    Route::Post('/handleWithdrawalRequest', 'SavingsWithdrawalController@submitSavingsWithdrawal');

    //submit profile for update
    Route::Post('/handleUserProfileUpdate', 'UserProfileController@updateProfile');
    Route::Get('/dashboard/userProfile/updateUserprofile', 'UserProfileController@showUserProfileForm')->name('update-user-profile');

    //render report form
    Route::get('reports/user/userReportTemplate','UserReportController@renderUserReportTemplate');

    //generate account statement from link
    Route::get('reports/user/accountStatement','UserReportController@generateAccountStatement');
    Route::get('reports/user/loanStatement','UserReportController@generateLoanStatementFromLink');
    Route::get('reports/user/transactionStatement','UserReportController@generateTransactionStatement');
    Route::get('reports/user/dividends','UserReportController@printDividends');

    Route::POST('/filterAccountStatement','UserReportController@generateUserReport');

    Route::POST('/filterExcelAccountStatement','UserReportController@generateExcelFilteredAccountStatement');

    //user transactions links
    Route::get('/transactions/myTransactions','TransactionController@showUserTransaction');

    //Election center link
    Route::Get('/elections/electionCenter','ElectionController@showElectionPage');

    //Election center link
    Route::Get('/comments/comment','CommentController@showCommentPage');



});

//Admin routes
Route::middleware(['auth','admin'])->group(function() {
    Route::get('/dashboard/admin/adminHome', 'AdminHomeController@showAdminHome')->name('admin-home');

    Route::get('/dashboard/admin/loanApplicationList', 'AdminLoanApprovalController@showLoanApplicationList')->name('admin-home');

    Route::get('/dashboard/admin/adminLoanApproval/{id}', 'AdminLoanApprovalController@showLoanDetails')->name('admin-home');

    Route::Post('/handleLoanAdminApproval', 'AdminLoanApprovalController@approveLoan');

    Route::get('dashboard/admin/savingsWithdrawals', 'AdminSavingsWithdrawalApprovalController@showSavingsWithdrawal')->name('admin-home');

    Route::get('dashboard/admin/savingsAuthorizations', 'AdminSavingsWithdrawalApprovalController@showSavingsAuthorization')->name('admin-home');

    Route::get('dashboard/admin/savingsWithdrawalsTransactions', 'AdminSavingsWithdrawalApprovalController@showSavingsWithdrawalsTransactions')->name('admin-home');

    Route::Post('/approveAuthorityToDeductPay', 'AdminSavingsWithdrawalApprovalController@approveAuthToDeductPay');

    Route::Post('/increaseDecreaseSavingApproval', 'AdminSavingsWithdrawalApprovalController@approveIncreaseDecreaseSaving');

    Route::get('/dashboard/admin/savingsWithdrawalApproval/{saving_id}', 'AdminSavingsWithdrawalApprovalController@approveSavingsWithdrawalForm')->name('admin-home');

    Route::Post('/handleAdminWithdrawalApproval', 'AdminSavingsWithdrawalApprovalController@approveSavingWithdrawalAction');

    //membership applications
    Route::get('/dashboard/admin/membershipApplication', 'AdminMembershipApplicationApprovalController@showMembershipApplication')->name('admin-home');
    Route::get('/dashboard/admin/membershipApproval/{application_id}', 'AdminMembershipApplicationApprovalController@showMembershipApplicationDetails')->name('admin-home');
    Route::get('/dashboard/admin/membershipRenewal', 'AdminMembershipApplicationApprovalController@showMembershipRenewalRequests')->name('admin-home');
    Route::get('/dashboard/admin/membershipRenewalApproval/{request_id}', 'AdminMembershipApplicationApprovalController@showMembershipRenewalDetails')->name('admin-home');

    Route::Post('/handleAdminMembershipApproval', 'AdminMembershipApplicationApprovalController@approveMembershipApplication')->name('admin-home');
    Route::Post('/handleAdminMembershipRenewal', 'AdminMembershipApplicationApprovalController@approveMembershipRenewalRequest')->name('admin-home');
    //admin file links
    Route::get('dashboard/admin/adminFile/downloadTemplate', 'AdminFileManagementController@downloadSavingsTemplate');
    //create file and proceed
    Route::Post('dashboard/admin/adminFile/importMonthlyDeposit', 'AdminFileManagementController@importMonthlyDeposit');
    Route::GET('dashboard/admin/adminFile/monthlyDepositUpload', 'AdminFileManagementController@showMonthlyDepositUploadForm')->name('admin-home');

    //Loan repayment routes
    Route::GET('dashboard/admin/loanInstallmentsPayment', 'AdminLoanInstalmentSettlementController@showLoanInstalments')->name('admin-home');
    Route::POST('/settleLoanInstallments', 'AdminLoanInstalmentSettlementController@settleLoanInstallments');

    //Accounting Routes
    Route::GET('dashboard/admin/accounting/reportTemplate', 'AdminAccountingController@displayReportTemplate')->name('admin-home');
    Route::GET('dashboard/admin/accounting/createAccountChart', 'AdminAccountingController@displayAccountChartForm')->name('admin-home');
    Route::POST('/createAccountChart', 'AdminAccountingController@createAccountChart');
    Route::DELETE('/deleteAccountChart', 'AdminAccountingController@deleteAccountChart');
    Route::PUT('/updateAccountChart', 'AdminAccountingController@updateAccountChart');
    Route::GET('dashboard/admin/accounting/recordExpense', 'AdminAccountingController@displayExpenseForm')->name('admin-home');
    Route::GET('dashboard/admin/accounting/createJournals', 'AdminAccountingController@displayJournalForm')->name('admin-home');
    Route::POST('/createAccountJournal', 'AdminAccountingController@createJournals');
    Route::DELETE('/deleteAccountJournal', 'AdminAccountingController@deleteJournal');
    Route::PUT('/updateAccountJournal', 'AdminAccountingController@updateJournal');
    Route::POST('/registerCoopExpense', 'AdminAccountingController@registerExpenses');
    Route::POST('/cancelExpense', 'AdminAccountingController@cancelPostedExpense');
    Route::POST('/reportExpenses', 'AdminAccountingController@repostCancelledExpenses');

    //admin reports routes
    Route::get('dashboard/admin/reports/adminReportFilter','AdminReportController@renderReportFilter')->name('admin-home');
    Route::POST('/filterReports','AdminReportController@generateReports');
    Route::POST('/permitMultipleLoan','AdminLoanApprovalController@grantApprovalForMultipleLoan');

    //product routes
    Route::get('dashboard/admin/products/manageProduct','LoanProductController@renderProductForm')->name('admin-home');
    Route::POST('/createLoanProduct', 'LoanProductController@createProduct');
    Route::DELETE('/deleteLoanProduct', 'LoanProductController@destroyProduct');

    //settings routes
    Route::get('dashboard/admin/settings/setUpCharges','ConfigurationController@renderConfigurationForm')->name('admin-home');
    Route::POST('/createCharges', 'ConfigurationController@createCharges');
    Route::DELETE('/deleteCharges', 'ConfigurationController@destroyCharges');
    Route::Get('dashboard/admin/settings/importModels', 'AdminFileManagementController@showImportModelForm')->name('admin-home');
    Route::POST('/easyImportModels', 'AdminFileManagementController@importSomeModels');
    Route::Get('dashboard/admin/settings/setUpDepartments', 'ConfigurationController@showCreateDepartmentForm')->name('admin-home');
    Route::POST('/createDepartment', 'ConfigurationController@createDepartmentOrZone');
    Route::DELETE('/deleteDepartment', 'ConfigurationController@destroyDepartment');

    //logs routes
    Route::get('dashboard/admin/settings/viewLogs','ConfigurationController@renderLogView')->name('admin-home');

    //member transaction routes
    Route::get('dashboard/admin/membersTransactions','AdminMemberTransactionController@showMembersTransactions')->name('admin-home');

    //role and permission routes
    Route::get('dashboard/admin/config/configRolePermission','AdminRoleAndPermissionController@showRolePermissionForm')->name('admin-home');

    //dividends & transfer routes
    Route::get('dashboard/admin/accounting/declareDividends','AdminCalculationController@showDividendForm')->name('admin-home');
    Route::POST('dashboard/admin/accounting/declareDividends', 'AdminCalculationController@declareDividendsPostTransfers');
    Route::GET('dashboard/admin/accounting/dividendsList', 'AdminCalculationController@showDeclaredDividends')->name('admin-home');

    //assign user role
    Route::POST('/assignUserRole', 'AdminRoleAndPermissionController@assignUserRoleAndPermission');
    Route::POST('/revokeUserRole', 'AdminRoleAndPermissionController@revokeRoleAndPermission');

});



