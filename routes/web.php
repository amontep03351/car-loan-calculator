<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\VehicleCrud;
use App\Http\Livewire\UserManagement;
use App\Http\Livewire\CarLoanCalculator;
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
// web.php
Route::middleware(['auth', 'active'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/vehicle-crud', VehicleCrud::class)->middleware('auth')->name('/vehicle-crud');
    Route::get('/car-loan-calculator', CarLoanCalculator::class)->middleware('auth')->name('/car-loan-calculator'); 

    Route::middleware('admin')->group(function () {
        Route::get('/user-management', UserManagement::class)->middleware('auth')->name('/user-management');
    });
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {

    

 

});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/access-denied', function () {
    return view('access-denied');
});