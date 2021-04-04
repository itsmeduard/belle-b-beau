<?php
use Illuminate\Support\Facades\{Auth,Route};
use App\Http\Controllers\HomeController;
use App\Http\Livewire\{ LivewireAppointment, Admin\LivewireDashboard, Admin\LivewireService };

Route::get('/',LivewireAppointment::class);

Auth::routes(['verify' => true]);

Route::get('/log-out', [HomeController::class, 'log_out'])->name('log-out');

Route::get('/home', [HomeController::class, 'index'])->name('home');

/*Set appointment*/
Route::post('/appointment', [LivewireAppointment::class, 'store'])->name('appointment.store');

Route::group(['middleware' => 'auth'], function() {
    Route::group(['middleware' => 'role:admin', 'prefix' => 'admin', 'as' => "admin."], function() {
        Route::get('dashboard', LivewireDashboard::class)->name('dashboard');
        Route::get('service', LivewireService::class)->name('service');
    });
});

Route::get('/clear', function() {
    Artisan::call('route:cache');
    Artisan::call('view:clear');
    Artisan::call('config:clear');
    return 'Cleared';
});


