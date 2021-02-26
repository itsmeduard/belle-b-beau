<?php
use Illuminate\Support\Facades\{Auth,Route};

Route::view('/', 'welcome');

Auth::routes(['verify' => true]);

Route::get('/log-out', [App\Http\Controllers\HomeController::class, 'logout'])->name('log-out');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('admin/dashboard/', App\Http\Controllers\Admin\AdminController::class, ['names' => 'dashboard']);

Route::get ( '/redirect/{service}', [App\Http\Controllers\Auth\LoginController::class, 'redirect']);

Route::get ( '/callback/{service}', [App\Http\Controllers\Auth\LoginController::class, 'callback']);
