<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BillSetupController;
use App\Http\Controllers\BlanceController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\ExpDetailController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ExpSetupController;
use App\Http\Controllers\FlatController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\LadgerController;
use App\Http\Controllers\OthersIncomeController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PdfGeneratorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RentalAgreementController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\User\AccountController;
use App\Http\Controllers\User\ExpenseController as UserExpenseController;
use App\Http\Controllers\User\ExpSetupController as UserExpSetupController;
use App\Http\Controllers\User\FlatController as UserFlatController;
use App\Http\Controllers\User\GuestController as UserGuestController;
use App\Http\Controllers\User\IncomeController as UserIncomeController;
use App\Http\Controllers\User\ReportController as UserReportController;
use App\Http\Controllers\User\VendoreController as UserVendoreController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendoreController;
use App\Http\Controllers\VoucherController;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Route;

/*---------------- Admin route start here ------------------*/
// admin login route start here 

Route::get('/admin/login', [AdminController::class, 'Index'])->name('login_form');
Route::post('/admin/login/owner', [AdminController::class, 'Login'])->name('admin.login');

// admin register route start here 
Route::get('/admin/register', [AdminController::class, 'AdminRegister'])->name('register_form');
Route::post('/admin/register/store', [AdminController::class, 'Store'])->name('admin.store');
Route::get('/admin/register-verify', [AdminController::class, 'Verify'])->name('admin.verfy');
Route::post('/admin/register-verify/store', [AdminController::class, 'VerifyStore'])->name('admin.verfy.store');
Route::get('/admin/register-verified', [AdminController::class, 'Verified'])->name('admin.verfied');
// admin register route ends here 

// Customer Forgate password route start here 
Route::get('/admin/forgot-password', [AdminController::class, 'Forgot'])->name('admin.forgot-password');
Route::post('/admin/forgot-password/create', [AdminController::class, 'ForgotPassword'])->name('admin.forgot-password.create');
Route::get('/admin/reset/{token}', [AdminController::class, 'Reset']);
Route::post('/admin/reset/{token}', [AdminController::class, 'PostReset']);
// Customer Forgate password route ends here 

Route::group(['prefix' => 'admin', 'middleware' => ['admin']], function () {
    Route::get('/dashboard', [AdminController::class, 'Dashboard'])->name('admin.dashboard');
    Route::get('/get-transaction/{date}', [AdminController::class, 'GetTransaction']); // get current transaction for Dashboard

    // client show 
    Route::get('/clients', [AdminController::class, 'Client'])->name('client.all');
    Route::get('/client/edit/{id}', [AdminController::class, 'ClientEdit'])->name('client.edit');
    Route::post('/client/update', [AdminController::class, 'ClientUpdate'])->name('client.update');

    // customer status activation route 
    Route::get('/client/active/{id}', [AdminController::class, 'ClientActive'])->name('client.active');
    Route::get('/client/not-active/{id}', [AdminController::class, 'ClientNotActive'])->name('client.notactive');
    // client data deleted 
    Route::get('/clients/all', [AdminController::class, 'ClientAll'])->name('client.index');
    Route::post('/client/delete', [AdminController::class, 'ClientDataDelete'])->name('client.data.delete');

    // admin login route start here 
    Route::post('/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');

    //    Category route 
    Route::get('/category', [CategoryController::class, 'Index'])->name('category.index');
    Route::get('/category/create', [CategoryController::class, 'Create'])->name('category.create');
    Route::post('/category/store', [CategoryController::class, 'Store'])->name('category.store');
    // Route::get('/category/edit/{id}', [CategoryController::class, 'Edit'])->name('category.edit');
    // Route::post('/category/update', [CategoryController::class, 'Update'])->name('category.update');
    Route::get('/category/delete/{id}', [CategoryController::class, 'Destroy'])->name('category.delete');

    // Packages route  
    Route::get('/packages', [PackageController::class, 'Index'])->name('package.all');
    Route::get('/package/create', [PackageController::class, 'Create'])->name('package.create');
    Route::post('/package/store', [PackageController::class, 'Store'])->name('package.store');
    Route::get('/package/edit/{id}', [PackageController::class, 'Edit'])->name('package.edit');
    Route::post('/package/update', [PackageController::class, 'Update'])->name('package.update');
    Route::get('/package/delete/{id}', [PackageController::class, 'Delete'])->name('package.delete');

    // Payment route  
    Route::get('/client-collections', [PaymentController::class, 'Index'])->name('collections.all');
    Route::get('/collection/create', [PaymentController::class, 'Create'])->name('collection.create');
    Route::post('/get-package', [PaymentController::class, 'GetPackage']); // get subcategory using ajex 
    Route::post('/collection/store', [PaymentController::class, 'Store'])->name('collection.store');
    // Route::get('/collection/edit/{id}', [PaymentController::class, 'Edit'])->name('collection.edit');
    // Route::post('/collection/update', [PaymentController::class, 'Update'])->name('collection.update');
    // Route::get('/collection/delete/{id}', [PaymentController::class, 'Delete'])->name('collection.delete');
});

/*---------------- Admin route ends here ------------------*/
/*---------------- Customer route start here ------------------*/
Route::group(['prefix' => 'admin', 'middleware' => ['admin']], function () {
    // Flat setup route 
    Route::get('/building-manage', [BuildingController::class, 'Index'])->name('building.index');
    Route::get('/building-manage/create', [BuildingController::class, 'Create'])->name('building.create');
    Route::post('/building-manage/store', [BuildingController::class, 'Store'])->name('building.store');
    Route::get('/building-manage/edit/{id}', [BuildingController::class, 'Edit']);
    Route::post('/building-manage/update', [BuildingController::class, 'Update'])->name('building.update');
  
    // Flat setup route 
    Route::get('/manage-flat', [FlatController::class, 'Index'])->name('flat.index');
    Route::get('/manage-flat/create', [FlatController::class, 'Create'])->name('flat.create');
    Route::post('/manage-flat/store', [FlatController::class, 'Store'])->name('flat.store');
    Route::get('/manage-flat/edit/{id}', [FlatController::class, 'Edit']);
    Route::post('/manage-flat/update', [FlatController::class, 'Update'])->name('flat.update');

    // Tenant setup route 
    Route::get('/tenant', [TenantController::class, 'Index'])->name('tenant.index');
    Route::get('/tenant/create', [TenantController::class, 'Create'])->name('tenant.create');
    Route::post('/tenant/store', [TenantController::class, 'Store'])->name('tenant.store');
    Route::get('/tenant/edit/{id}', [TenantController::class, 'Edit'])->name('tenant.edit');
    Route::post('/tenant/update', [TenantController::class, 'Update'])->name('tenant.update');

    // Tenant setup route 
    Route::get('/tenant-document', [TenantController::class, 'AllDocuments'])->name('tenant-document.index');
    Route::get('/tenant-document/create', [TenantController::class, 'CreateDocument'])->name('tenant-document.create');
    Route::post('/tenant-document/store', [TenantController::class, 'StoreDocument'])->name('tenant-document.store');
    Route::get('/tenant-document/edit/{id}', [TenantController::class, 'EditDocument']);
    Route::post('/tenant-document/update', [TenantController::class, 'UpdateDocument'])->name('tenant-document.update');
    // Document view route start here
    Route::get('/tenant-document/show/{id}', [TenantController::class, 'ShowDocument'])->name('tenant-document.show');

    // Rental Agreement route 
    Route::get('/rental-agreement', [RentalAgreementController::class, 'Index'])->name('rental-agreement.index');
    Route::get('/rental-agreement/create', [RentalAgreementController::class, 'Create'])->name('rental-agreement.create');
    Route::post('/rental-agreement/store', [RentalAgreementController::class, 'Store'])->name('rental-agreement.store');
    Route::get('/rental-agreement/edit/{id}', [RentalAgreementController::class, 'Edit'])->name('rental-agreement.edit');
    Route::post('/rental-agreement/update', [RentalAgreementController::class, 'Update'])->name('rental-agreement.update');
    // money receipt route 
    Route::get('/rental-agreement/money-receipt/{id}', [RentalAgreementController::class, 'MoneyReceipt'])->name('rental-agreement.money-receipt');
    // get data using ajax
    Route::post('/get-flat', [RentalAgreementController::class, 'GetFlat']);
    Route::post('/get-flat-info', [RentalAgreementController::class, 'GetFlatInfo']);

    // Bill Setup route 
    Route::get('/bill-setup', [BillSetupController::class, 'Index'])->name('bill-setup.index');
    Route::get('/bill-setup/filter/{tenantId?}/{date?}', [BillSetupController::class, 'FilterBills']); //bill setup filter using ajax 
    Route::get('/bill-setup/create', [BillSetupController::class, 'Create'])->name('bill-setup.create');
    Route::post('/bill-setup/store', [BillSetupController::class, 'Store'])->name('bill-setup.store');

    // Collection Setup route 
    Route::get('/rent-collection', [CollectionController::class, 'Index'])->name('rent-collection.index');
    Route::get('/rent-collection-all/filter/{tenantId?}/{date?}', [CollectionController::class, 'AllCollectionfilter']); //bill setup filter using ajax 
    Route::get('/rent-collection/create', [CollectionController::class, 'Create'])->name('rent-collection.create');
    Route::get('/rent-collection/filter/{tenantId?}/{date?}', [CollectionController::class, 'Collectionfilter']); //bill setup filter using ajax 
    Route::post('/rent-collection/store', [CollectionController::class, 'Store'])->name('rent-collection.store');

    Route::get('/collection/money-receipt/{id}', [CollectionController::class, 'MoneyReceipt'])->name('collection.money-receipt'); //many receipt for collection
    
    // users route 
    Route::get('/users', [UserController::class, 'Index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'Create'])->name('users.create');
    Route::post('/users/store', [UserController::class, 'Store'])->name('users.store');
    Route::get('/users/edit/{id}', [UserController::class, 'Edit']);
    Route::post('/users/update', [UserController::class, 'Update'])->name('users.update');
    Route::post('/users/delete', [UserController::class, 'Destroy'])->name('users.delete');

    // single users route
    Route::get('/user/create', [UserController::class, 'SingleCreate'])->name('user.create');
    Route::post('/user/store', [UserController::class, 'SingleStore'])->name('user.store');

    // Expense-setup route start here 
    Route::get('/expense-setup/create', [ExpenseController::class, 'Exp_setup'])->name('exp_setup.create'); //create exp-setup
    Route::post('/expense-setup/store', [ExpenseController::class, 'Exp_setupStore'])->name('exp_setup.store'); //store exp-setup
    Route::get('/expense-setup/edit/{id}', [ExpenseController::class, 'Exp_setupEdit']);
    Route::post('/expense-setup/update', [ExpenseController::class, 'Exp_setupUpdate'])->name('exp_setup.update');
    // Expense-setup route ends here

    // Expense route start here
    Route::get('/expense/create', [ExpenseController::class, 'Create'])->name('expense.create');
    Route::post('/expense/store', [ExpenseController::class, 'Store'])->name('expense.store');
    Route::get('/expense/edit/{id}', [ExpenseController::class, 'Edit']);
    Route::post('/expense/update', [ExpenseController::class, 'Update'])->name('expense.update');
    Route::get('/expense/delate/{id}', [ExpenseController::class, 'Delate'])->name('expense.delate');
    // Expense route ends here

    Route::get('/expense-summary', [ExpenseController::class, 'Index'])->name('expense-summary.index');

    // // Expense setup route 
    // Route::get('/expense-setup', [ExpSetupController::class, 'ExpenseSetupIndex'])->name('expense.setup');
    // Route::post('/expense-setup/create', [ExpSetupController::class, 'ExpenseSetupCreate'])->name('expense.setup.create');
    // Route::get('/expense-setup/edit/{id}', [ExpSetupController::class, 'ExpenseSetupEdit'])->name('expense.setup.edit');
    // Route::post('/expense-setup/update', [ExpSetupController::class, 'ExpenseSetupUpdate'])->name('expense.setup.update');

    // setup history route 
    Route::get('/expense-setup/history', [ExpSetupController::class, 'ExpenseSetupHistory'])->name('expense.setup.history');
    Route::get('/expense-setup/history/all/{exp_id}', [ExpSetupController::class, 'ExpenseSetupHistoryAll']);

    // Vendore route 
    Route::get('/vendor-all', [VendoreController::class, 'VendorIndex'])->name('vendor.all');
    Route::get('/vendor/create', [VendoreController::class, 'VendorCreate'])->name('vendor.create');
    Route::post('/vendor/store', [VendoreController::class, 'VendorStore'])->name('vendor.store');
    Route::get('/vendor/edit/{id}', [VendoreController::class, 'VendorEdit'])->name('vendor.edit');
    Route::post('/vendor/update', [VendoreController::class, 'VendorUpdate'])->name('vendor.update');


    // report route start here 
    // Route::get('/expenses/all', [ExpProcessController::class, 'Index'])->name('expenses.process');
    Route::get('/expenses/month', [ExpDetailController::class, 'MonthlyExpense'])->name('expenses.month');

    // account route start here 
    Route::get('/ledger-posting', [LadgerController::class, 'Index'])->name('ledgerPosting.index');
    Route::get('/ledger-posting/store', [LadgerController::class, 'Store'])->name('ledger-posting.store');
    // Route::get('/expense-process/store', [ExpProcessController::class, 'Store'])->name('expense_process.store');
    Route::get('/opening-balance/create', [BlanceController::class, 'OpeningBalance'])->name('opening.balance.create');
    Route::post('/opening-balance/store', [BlanceController::class, 'OpeningBalanceStore'])->name('opening.balance.store');
    // account route ends here 

    //    Expense process route 
    // Route::get('/expense.process', [ExpProcessController::class, 'Index'])->name('expenses.index');
    // // Route::get('/expense-process/store', [ExpProcessController::class, 'Store'])->name('expense_process.store');

    //    income route  
    Route::get('/income', [IncomeController::class, 'Create'])->name('income.create');
    Route::post('/income/store', [IncomeController::class, 'Store'])->name('income.store');
    Route::get('/income/collection', [IncomeController::class, 'Collection'])->name('income.collection');
    Route::post('/income/collection/store/', [IncomeController::class, 'StoreCollection'])->name('income.collection.store');


    /*------------------------- Expense voucher route srtart here-------------------------*/
    // // Expense Management 
    // Route::get('/expense/create-voucher/{id}', [PdfGeneratorController::class, 'CreateVoucher'])->name('expense.voucher.create');
    // Route::post('/expense/create-voucher/store', [PdfGeneratorController::class, 'CreateVoucherStore'])->name('expense.voucher.store');
    Route::get('/account/voucher/{id}', [PdfGeneratorController::class, 'GenerateVoucher'])->name('expense.voucher.create');  //create single expense voucher
    // Route::post('/expense/generate-voucher', [PdfGeneratorController::class, 'GenerateVoucher'])->name('expense.voucher.generate');
    Route::post('/expense/generate-voucher-all', [PdfGeneratorController::class, 'GenerateVoucherAll'])->name('expense.voucher.generateall');
    // Expense Accounts 
    
    /*------------------------- expense voucher route srtart here-------------------------*/

    /*------------------------- income voucher route start here-------------------------*/
    Route::get('/income/generate-voucher/{id}', [PdfGeneratorController::class, 'GenerateIncomeVoucher'])->name('income.voucher.generate');
    Route::post('/income/generate-voucher-all', [PdfGeneratorController::class, 'GenerateIncomeVoucherAll'])->name('income.voucher.generateall');
    /*------------------------- income voucher route ends here-------------------------*/

    /*--------------- Accounts voucher route start here ------------------*/
    // collection
    Route::get('/income/collection-voucher', [VoucherController::class, 'Index'])->name('income.collection.index');
    Route::post('/income/collection-all', [VoucherController::class, 'CollectionAll'])->name('income.collection.all');

    // accont expense route
    Route::get('/account/expense-voucher', [VoucherController::class, 'ExpenseIndex'])->name('account.expense.index');
    Route::post('/account/expense-all', [VoucherController::class, 'ExpenseAll'])->name('account.expense.all');

    //Balance sheet
    Route::get('/account/balance', [VoucherController::class, 'BalanceSheetIndex'])->name('account.balancesheet');
    Route::get('/account/balance-sheet/{year}/{month}', [VoucherController::class, 'BalanceSheet'])->name('account.allbalancesheet');

    Route::get('/income-statement', [VoucherController::class, 'Incomes'])->name('income.statement');
    /*--------------- Accounts voucher route ends here ------------------*/

    /*--------------- Report route start here ------------------*/
    Route::get('/bills/report', [ReportController::class, 'BillReport'])->name('bills.report');
    Route::post('/collection/report', [ReportController::class, 'CollectionReport'])->name('collection.report');
    Route::post('/due/report', [ReportController::class, 'DueReport'])->name('due.report');

    Route::get('/expenses/month', [ReportController::class, 'MonthlyExpense'])->name('expenses.month');
    Route::post('/expenses-all/month', [ReportController::class, 'MonthlyAllExpense'])->name('expensesall.month');

    Route::get('/expenses/yearly', [ReportController::class, 'YearlyExpense'])->name('expenses.year');
    Route::post('/expenses-all/year', [ReportController::class, 'YearlyAllExpense'])->name('expensesall.year');

    // Route::get('/incomes/month', [ReportController::class, 'MonthlyIncome'])->name('incomes.month');
    // Route::post('/monthly-income', 'ReportControllerMonthlyIncome')->name('incomesall.month');

    Route::get('/monthly-income', [ReportController::class, 'ShowMonthlyIncome'])->name('incomes.month');
    Route::post('/monthly-income', [ReportController::class, 'HandleMonthlyIncome'])->name('handle.monthly.income');


    // Route::post('/incomes-all/month', [ReportController::class, 'MonthlyAllIncome'])->name('incomesall.month');
    Route::get('/incomes/yearly', [ReportController::class, 'YearlyIncome'])->name('incomes.year');
    Route::post('/incomes-all/yearly', [ReportController::class, 'YearlyAllIncome'])->name('incomesall.year');

    /*--------------- Report route ends here ------------------*/

    /*--------------- Others Income route start here ------------------*/
    Route::get('/others-income/create', [OthersIncomeController::class, 'OthersIncomeCreate'])->name('others.income.create');
    Route::post('/others-income/store', [OthersIncomeController::class, 'OthersIncomeStore'])->name('others.income.store');
    /*--------------- Others Income route ends here ------------------*/

    //    Balance route 
    // Route::get('/balance/month', [BlanceController::class, 'Monthly'])->name('monthly.blance.index');
    // Route::get('/balance/year', [BlanceController::class, 'Yearly'])->name('yearly.blance.index');


    //    Report route 
    Route::get('/balance-sheet', [BlanceController::class, 'BalanceSheet'])->name('blance.index');
    // Route::get('/all-expenses', [BlanceController::class, 'Expenses'])->name('expense-all.index');

    // Guest Manage 
    Route::get('/guest-book/all', [GuestController::class, 'Index'])->name('guestBook.index');
    Route::get('/guest-book/create', [GuestController::class, 'Create'])->name('guestBook.create');
    Route::post('/guest-book/store', [GuestController::class, 'Store'])->name('guestBook.store');
    Route::get('/guest-book/edit/{id}', [GuestController::class, 'Edit'])->name('guestBook.edit');
    Route::post('/guest-book/update', [GuestController::class, 'Update'])->name('guestBook.update');
    Route::get('/guest-book/history', [GuestController::class, 'ShowHistory'])->name('guestBook.history');
});

/*---------------- Customer route ends here ------------------*/

/*---------------- User route start here ------------------*/
Route::get('/user-login', [UserController::class, 'LoginForm'])->name('user.login_form');
Route::post('/user-login/owner', [UserController::class, 'Login'])->name('user.login');

Route::middleware('auth')->group(function () {
    Route::get('/user/profile', [UserController::class, 'Profile'])->name('user.Profile');
    Route::get('/get-transaction/{date}', [UserController::class, 'GetTransaction']); // get current transaction for Dashboard
    // admin login route start here 
    Route::post('/user/logout', [AccountController::class, 'AdminLogout'])->name('manager.logout');
    /*---------------- Manager route start here ------------------*/
    // Route::get('/dashboard', [AdminController::class, 'Dashboard'])->name('admin.dashboard');

    // flat route start here 
    Route::get('/manage-flat', [UserFlatController::class, 'Index'])->name('manager.flat.index');
    Route::get('/manage-flat/single-create', [UserFlatController::class, 'SingleCreate'])->name('manager.flat.singlecreate');
    Route::post('/manager/manage-flat/single-store', [UserFlatController::class, 'SingleStore'])->name('manager.flat.singlestore');
    // flat route start here 

    //    users route 
    Route::get('/users', [UserFlatController::class, 'UserIndex'])->name('manager.users.index');
    Route::get('/users/edit/{id}', [UserFlatController::class, 'Edit']);
    Route::post('/users/update', [UserFlatController::class, 'Update'])->name('manager.users.update');

    //    Expense-details route 
    Route::get('/expense/create', [UserExpenseController::class, 'Create'])->name('manager.expense.create');
    Route::post('/expense/store', [UserExpenseController::class, 'Store'])->name('manager.expense.store');
    Route::get('/expense-details/edit/{id}', [UserExpenseController::class, 'Edit']);
    Route::post('/expense-details/update', [UserExpenseController::class, 'Update'])->name('manager.expense-details.update');
    Route::get('/expense-details/delate/{id}', [UserExpenseController::class, 'Delate'])->name('manager.expense-details.delate');

    Route::get('/expense-summary', [UserExpenseController::class, 'Index'])->name('manager.expense-summary.index');
    Route::get('/expenses/month', [UserExpenseController::class, 'MonthlyExpense'])->name('manager.expenses.month');

    // Expense Management 
    Route::get('/expense/create-voucher/{id}', [UserExpenseController::class, 'CreateVoucher'])->name('manager.expense.voucher.create');
    Route::post('/expense/create-voucher/store', [UserExpenseController::class, 'CreateVoucherStore'])->name('manager.expense.voucher.store');
    Route::post('/expense/generate/voucher', [UserExpenseController::class, 'GenerateVoucher'])->name('manager.expense.voucher.generate');
    Route::get('/expense/generate-voucher-all', [UserExpenseController::class, 'GenerateVoucherAll'])->name('manager.expense.voucher.generateall');

    //    income route  
    Route::get('/income', [UserIncomeController::class, 'Create'])->name('manager.income.create');
    Route::post('/income/store', [UserIncomeController::class, 'Store'])->name('manager.income.store');
    Route::get('/income/collection', [UserIncomeController::class, 'Collection'])->name('manager.income.collection');
    Route::post('/income/collection/store/', [UserIncomeController::class, 'StoreCollection'])->name('manager.income.collection.store');

    Route::get('/income/collection-voucher', [UserIncomeController::class, 'Index'])->name('manager.income.collection.index');
    Route::post('/income/collection-all', [UserIncomeController::class, 'CollectionAll'])->name('manager.income.collection.all');

    /*------------------------- income voucher route start here-------------------------*/
    Route::get('/income/generate-voucher/{id}', [UserIncomeController::class, 'GenerateIncomeVoucher'])->name('manager.income.voucher.generate');
    Route::post('/income/generate-voucher-all', [UserIncomeController::class, 'GenerateIncomeVoucherAll'])->name('manager.income.voucher.generateall');
    /*------------------------- income voucher route ends here-------------------------*/

    // account route start here 
    Route::get('/ledger-posting', [AccountController::class, 'Index'])->name('manager.ledgerPosting.index');
    Route::get('/ledger-posting/store', [AccountController::class, 'Store'])->name('manager.ledger-posting.store');

    /*--------------- Accounts voucher route start here ------------------*/
    // collection
    // Route::get('/income/collection-voucher', [AccountController::class, 'IndexCollection'])->name('manager.income.collection.index');
    // Route::post('/income/collection-all', [AccountController::class, 'CollectionAll'])->name('manager.income.collection.all');
    //expense
    Route::get('/account/expense-voucher', [AccountController::class, 'ExpenseIndex'])->name('manager.account.expense.index');
    Route::post('/account/expense-all', [AccountController::class, 'ExpenseAll'])->name('manager.account.expense.all');
    Route::post('/account/expense-voucher-all', [AccountController::class, 'GenerateExpenseVoucherAll'])->name('manager.account.expense.voucher.generateall');
    //Balance sheet
    // Route::get('/account/balance', [AccountController::class, 'BalanceSheet'])->name('manager.account.balancesheet');
    // Route::post('/account/balance-all', [AccountController::class, 'AllBalanceSheet'])->name('manager.account.allbalancesheet');
    //Balance sheet
    Route::get('/account/balance', [AccountController::class, 'BalanceSheetIndex'])->name('manager.account.balancesheet');
    Route::get('/account/balance-sheet/{year}/{month}', [AccountController::class, 'BalanceSheet'])->name('manager.account.allbalancesheet');


    Route::get('/income-statement', [AccountController::class, 'Incomes'])->name('manager.income.statement');

    /*--------------- Accounts voucher route ends here ------------------*/

    /*--------------- Report route start here ------------------*/
    Route::get('/expenses/month', [UserReportController::class, 'MonthlyExpense'])->name('manager.expenses.month');
    Route::post('/expenses-all/month', [UserReportController::class, 'MonthlyAllExpense'])->name('manager.expensesall.month');

    Route::get('/expenses/yearly', [UserReportController::class, 'YearlyExpense'])->name('manager.expenses.year');
    Route::post('/expenses-all/year', [UserReportController::class, 'YearlyAllExpense'])->name('manager.expensesall.year');

    Route::get('/incomes/month', [UserReportController::class, 'MonthlyIncome'])->name('manager.incomes.month');
    Route::post('/incomes-all/month', [UserReportController::class, 'MonthlyAllIncome'])->name('manager.incomesall.month');

    Route::get('/incomes/yearly', [UserReportController::class, 'YearlyIncome'])->name('manager.incomes.year');
    Route::post('/incomes-all/yearly', [UserReportController::class, 'YearlyAllIncome'])->name('manager.incomesall.year');

    Route::get('/balance-sheet', [UserReportController::class, 'BalanceSheet'])->name('manager.blance.index');
    /*--------------- Report route ends here ------------------*/

    // Expense setup route 
    Route::get('/manager/expense-setup', [UserExpSetupController::class, 'ExpenseSetupIndex'])->name('manager.expense.setup');
    Route::post('/manager/expense-setup/create', [UserExpSetupController::class, 'ExpenseSetupCreate'])->name('manager.expense.setup.create');
    Route::get('/manager/expense-setup/edit/{id}', [UserExpSetupController::class, 'ExpenseSetupEdit'])->name('manager.expense.setup.edit');
    Route::post('/manager/expense-setup/update', [UserExpSetupController::class, 'ExpenseSetupUpdate'])->name('manager.expense.setup.update');

    // setup history route 
    Route::get('/manager/expense-setup/history', [UserExpSetupController::class, 'ExpenseSetupHistory'])->name('manager.expense.setup.history');
    Route::get('/manager/expense-setup/history/all/{exp_id}', [UserExpSetupController::class, 'ExpenseSetupHistoryAll']);


    // Vendore route 
    Route::get('/manager/vendor-all', [UserVendoreController::class, 'VendorIndex'])->name('manager.vendor.all');
    Route::get('/manager/vendor/create', [UserVendoreController::class, 'VendorCreate'])->name('manager.vendor.create');
    Route::post('/manager/vendor/store', [UserVendoreController::class, 'VendorStore'])->name('manager.vendor.store');
    Route::get('/manager/vendor/edit/{id}', [UserVendoreController::class, 'VendorEdit'])->name('manager.vendor.edit');
    Route::post('/manager/vendor/update', [UserVendoreController::class, 'VendorUpdate'])->name('manager.vendor.update');

    // Guest Manage 
    Route::get('/guest-book/all', [UserGuestController::class, 'Index'])->name('manager.guestBook.index');
    Route::get('/guest-book/create', [UserGuestController::class, 'Create'])->name('manager.guestBook.create');
    Route::post('/guest-book/store', [UserGuestController::class, 'Store'])->name('manager.guestBook.store');
    Route::get('/guest-book/edit/{id}', [UserGuestController::class, 'Edit'])->name('manager.guestBook.edit');
    Route::post('/guest-book/update', [UserGuestController::class, 'Update'])->name('manager.guestBook.update');
    Route::get('/guest-book/history', [UserGuestController::class, 'ShowHistory'])->name('manager.guestBook.history');

    /*---------------- Manager route ends here ------------------*/

    /*---------------- user route start here ------------------*/
    Route::get('/single-user/paid', [UserIncomeController::class, 'SingleUserPaid'])->name('singleUser.paid');
    Route::get('/single-user/due', [UserIncomeController::class, 'SingleUserDue'])->name('singleUser.due');
    Route::get('/user/reset-password', [UserIncomeController::class, 'PasswordReset'])->name('user.password.reset');
    Route::Post('/user/reset-password', [UserIncomeController::class, 'PasswordResetStore'])->name('user.password.reset.store');
    /*---------------- user route ends here ------------------*/

    /*---------------- User route ends here ------------------*/
});



Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
