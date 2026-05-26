<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Store;
use App\Livewire\Auth\Login;
use App\Livewire\HomePage;
use App\Livewire\Orders\OrderStatusScreen;
use App\Livewire\Orders\PosScreen;
use App\Livewire\Orders\OrdersList;
use App\Livewire\Orders\ViewOrder;
use App\Livewire\Orders\PrintOrder;
use App\Livewire\Customers\CustomersList;
use App\Livewire\Customers\CustomerView;
use App\Livewire\Customers\CustomerLedger;
use App\Livewire\Payments\PaymentsReceiptView;
use App\Livewire\Service\ServiceList;
use App\Livewire\Service\ServiceManage;
use App\Livewire\Service\ServiceEdit;
use App\Livewire\Service\ServiceAddonsList;
use App\Livewire\Service\ServiceTypesList;
use App\Livewire\Reports\DailyReport;
use App\Livewire\Reports\ExpenseReport;
use App\Livewire\Reports\LedgerReport;
use App\Livewire\Reports\OrderReport;
use App\Livewire\Reports\SalesReport;
use App\Livewire\Reports\TaxReport;
use App\Livewire\Reports\PrintReport\ExpenseReport as PrintExpenseReport;
use App\Livewire\Reports\PrintReport\SalesReport as PrintSalesReport;
use App\Livewire\Reports\PrintReport\TaxReport as PrintTaxReport;
use App\Livewire\Reports\PrintReport\OrderReport as PrintOrderReport;
use App\Livewire\Reports\PrintReport\DailyReport as PrintDailyReport;
use App\Livewire\Reports\DownloadReport\ExpenseReport as DownloadExpenseReport;
use App\Livewire\Reports\DownloadReport\SalesReport as DownloadSalesReport;
use App\Livewire\Reports\DownloadReport\TaxReport as DownloadTaxReport;
use App\Livewire\Reports\DownloadReport\OrderReport as DownloadOrderReport;
use App\Livewire\Expense\ExpenseList;
use App\Livewire\Expense\ExpenseCategoryList;
use App\Livewire\Settings\MasterSetting;
use App\Livewire\Settings\MailSettings;
use App\Livewire\Settings\FinancialYearSettings;
use App\Livewire\Settings\SmsSettings;
use App\Livewire\Settings\ThemeSettings;
use App\Livewire\Settings\FileTools;
use App\Livewire\Settings\Translations;
use App\Livewire\Settings\Translations\CreateTranslations;
use App\Livewire\Settings\Translations\EditTranslations;
use App\Livewire\Roles\RolesList;
use App\Livewire\Settings\Staff\StaffList;
use App\Livewire\Auth\Logout;
use App\Livewire\Auth\ForgotPassword;

Route::get('/reset-password/{token}', ForgotPassword::class);


Route::get('/', Login::class)->name('login');
Route::group(['prefix' => 'admin', 'middleware' => [Store::class]], function () {
    Route::get('/dashboard', HomePage::class)->name('admin.dashboard');
    Route::get('/pos', PosScreen::class)->name('orders.pos');
    Route::get('/pos/edit/{id}', PosScreen::class)->name('orders.pos.edit');
    Route::get('/order-status-screen', OrderStatusScreen::class)->name('orders.status-screen');
    Route::group(['prefix' => 'orders/'], function () {
        Route::get('/', OrdersList::class)->name('orders');
        Route::get('/view/{id}', ViewOrder::class)->name('order.view');
        Route::get('/print/{id}', PrintOrder::class)->name('order.print');
    });
    Route::group(['prefix' => 'customers/'], function () {
        Route::get('/', CustomersList::class)->name('customers');
        Route::get('/{id}', CustomerView::class)->name('customers.view');
        Route::get('/ledger/{id}', CustomerLedger::class)->name('customers.ledger');
    });
    Route::group(['prefix' => 'payments/'], function () {
        Route::get('/receipt', PaymentsReceiptView::class)->name('payments.receipt');
    });
    Route::group(['prefix' => 'service/'], function () {
        Route::get('/', ServiceList::class)->name('service');
        Route::get('/manage/{id?}', ServiceManage::class)->name('service.manage');
        Route::get('/edit/{id?}', ServiceEdit::class)->name('service.edit');
        Route::get('/addons', ServiceAddonsList::class)->name('service.addons');
        Route::get('/types', ServiceTypesList::class)->name('service.types');
    });
    Route::group(['prefix' => 'reports/'], function () {
        Route::get('/daily', DailyReport::class)->name('reports.daily');
        Route::get('/expense', ExpenseReport::class)->name('reports.expense');
        Route::get('/ledger', LedgerReport::class)->name('reports.ledger');
        Route::get('/order', OrderReport::class)->name('reports.order');
        Route::get('/sales', SalesReport::class)->name('reports.sales');
        Route::get('/tax', TaxReport::class)->name('reports.tax');
        /* print reports */
        Route::group(['prefix' => 'print-report/', 'middleware' => 'admin'], function () {
            Route::get('expense/{from_date}/{to_date}', PrintExpenseReport::class);
            Route::get('sales/{from_date}/{to_date}', PrintSalesReport::class);
            Route::get('tax/{from_date}/{to_date}/{category}', PrintTaxReport::class);
            Route::get('order/{from_date}/{to_date}/{status}', PrintOrderReport::class);
            Route::get('daily/{today}', PrintDailyReport::class);
        });
        /* download reports */
        Route::group(['prefix' => 'download-report/', 'middleware' => 'admin'], function () {
            Route::get('expense/{from_date}/{to_date}', DownloadExpenseReport::class);
            Route::get('sales/{from_date}/{to_date}', DownloadSalesReport::class);
            Route::get('tax/{from_date}/{to_date}/{category}', DownloadTaxReport::class);
            Route::get('order/{from_date}/{to_date}/{status}', DownloadOrderReport::class);
        });
    });
    /* expense */
    Route::group(['prefix' => 'expense/'], function () {
        Route::get('/', ExpenseList::class)->name('expense');
        Route::get('/category', ExpenseCategoryList::class)->name('expense.category');
    });
    /* settings */
    Route::group(['prefix' => 'settings/'], function () {
        Route::get('/master-settings', MasterSetting::class)->name('settings.master-settings');
        Route::get('/mail', MailSettings::class)->name('settings.mail-settings');
        Route::get('/financial-year', FinancialYearSettings::class)->name('settings.financial-year');
        Route::get('/sms', SmsSettings::class)->name('settings.sms');
        Route::get('/theme', ThemeSettings::class)->name('settings.theme');
        Route::get('/file', FileTools::class)->name('settings.file');
        Route::group(['prefix' => 'translations/'], function () {
            Route::get('/', Translations::class)->name('settings.translations');
            Route::get('/create', CreateTranslations::class)->name('settings.translations-create');
            Route::get('/edit/{id}', EditTranslations::class)->name('settings.translations-edit');
        });
        Route::get('/roles', RolesList::class)->name('settings.roles');
        Route::group(['prefix' => 'staff/'], function () {
            Route::get('/', StaffList::class)->name('settings.staff');
        });
    });
});
/* logout */
Route::get('/logout', Logout::class)->name('logout');

/* Customer Panel Routes */
use App\Livewire\CustomerPanel\Login as CustomerLogin;
use App\Livewire\CustomerPanel\Register as CustomerRegister;
use App\Livewire\CustomerPanel\Dashboard as CustomerDashboard;
use App\Livewire\CustomerPanel\Orders as CustomerOrders;
use App\Livewire\CustomerPanel\OrderCreate as CustomerOrderCreate;
use App\Livewire\CustomerPanel\OrderView as CustomerOrderView;
use App\Livewire\CustomerPanel\Logout as CustomerLogout;

Route::group(['prefix' => 'customer'], function () {
    Route::get('/login', CustomerLogin::class)->name('customer.login');
    Route::get('/register', CustomerRegister::class)->name('customer.register');
    
    Route::group(['middleware' => ['customer']], function () {
        Route::get('/dashboard', CustomerDashboard::class)->name('customer.dashboard');
        Route::get('/orders', CustomerOrders::class)->name('customer.orders');
        Route::get('/orders/create', CustomerOrderCreate::class)->name('customer.orders.create');
        Route::get('/orders/{id}', CustomerOrderView::class)->name('customer.orders.view');
        Route::get('/logout', CustomerLogout::class)->name('customer.logout');
    });
});
