<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\MultiRoleLoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', [MultiRoleLoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [MultiRoleLoginController::class, 'login'])
    ->middleware('throttle:5,1')
    ->name('login.submit');

Route::post('/logout', [MultiRoleLoginController::class, 'logout'])->name('logout');

Route::middleware(['auth:super_admin'])->group(function () {
    Route::get('/super-admin/dashboard', fn() => view('dashboards.super_admin'))->name('super_admin.dashboard');
});

Route::middleware(['auth:management'])->group(function () {
    Route::get('/management/dashboard', fn() => view('dashboards.management'))->name('management.dashboard');
});

Route::middleware(['auth:principal'])->group(function () {
    Route::get('/principal/dashboard', fn() => view('dashboards.principal'))->name('principal.dashboard');
});

Route::middleware(['auth:teacher'])->group(function () {
    Route::get('/teacher/dashboard', fn() => view('dashboards.teacher'))->name('teacher.dashboard');
});

Route::middleware(['auth:staff'])->group(function () {
    Route::get('/staff/dashboard', fn() => view('dashboards.staff'))->name('staff.dashboard');
});
