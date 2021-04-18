<?php
use Illuminate\Support\Facades\{Auth,Route};
use App\Http\Livewire\SuperAdmin\{SLivewireDashboard, SLivewireProfile};
use App\Http\Livewire\Admin\{ALivewireDashboard, ALivewireService,
    ALivewireEmployee, ALivewireProfile, ALivewireAppointment,
    ALivewireInvoiceAppointment, ALivewireInvoiceWalkin, ALivewireReport, ALivewireWalkin};
use App\Http\Livewire\Employee\{ELivewireDashboard, ELivewireProfile};
use App\Http\Livewire\Cashier\{CLivewireDashboard, CLivewireProfile};
use App\Http\Livewire\Manager\{MLivewireDashboard, MLivewireProfile};
use App\Http\Livewire\LivewireScheduleAppointment;
use App\Http\Controllers\HomeController;

Route::get('/',LivewireScheduleAppointment::class);

Auth::routes(['verify' => true]);

Route::get('/log-out', [HomeController::class, 'log_out'])->name('log-out');

Route::get('/home', [HomeController::class, 'index'])->name('home');

/*Set appointment*/
Route::post('/appointment', [LivewireScheduleAppointment::class, 'store'])->name('appointment.store');

Route::group(['middleware' => 'auth'], function() {
    Route::group(['middleware' => ['web','CheckAdmin'], 'prefix' => 'admin', 'as' => "admin."], function() {
        Route::get('dashboard', ALivewireDashboard::class)->name('dashboard');
        Route::get('service',   ALivewireService::class)->name('service');
        Route::get('employee',  ALivewireEmployee::class)->name('employee');
        Route::get('profile',   ALivewireProfile::class)->name('profile');
        Route::get('appointment',ALivewireAppointment::class)->name('appointment');
        Route::get('invoice_appointment',   ALivewireInvoiceAppointment::class)->name('invoice_appointment');
        Route::get('invoice_walkin',   ALivewireInvoiceWalkin::class)->name('invoice_walkin');
        Route::get('report',    ALivewireReport::class)->name('report');
        Route::get('walkin',    ALivewireWalkin::class)->name('walkin');
    });

    Route::group(['middleware' => 'CheckSuperadmin', 'prefix' => 'superadmin', 'as' => "superadmin."], function() {
        Route::get('dashboard', SLivewireDashboard::class)->name('dashboard');
        Route::get('profile',   SLivewireProfile::class)->name('profile');
    });

    Route::group(['middleware' => 'CheckCashier', 'prefix' => 'cashier', 'as' => "cashier."], function() {
        Route::get('dashboard', CLivewireDashboard::class)->name('dashboard');
        Route::get('profile',   CLivewireProfile::class)->name('profile');
    });

    Route::group(['middleware' => 'CheckManager', 'prefix' => 'manager', 'as' => "manager."], function() {
        Route::get('dashboard', MLivewireDashboard::class)->name('dashboard');
        Route::get('profile',   MLivewireProfile::class)->name('profile');
    });

    Route::group(['middleware' => 'CheckEmployee', 'prefix' => 'employee', 'as' => "employee."], function() {
        Route::get('dashboard', ELivewireDashboard::class)->name('dashboard');
        Route::get('profile',   ELivewireProfile::class)->name('profile');
    });
});

Route::get('/clear', function() {
    Artisan::call('route:cache');
    Artisan::call('view:clear');
    Artisan::call('config:cache');
    return 'Cleared';
});


