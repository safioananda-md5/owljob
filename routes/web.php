<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DebtController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\JobsController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return redirect(route('login'));
});

Route::get('/log-in', [AuthController::class, 'login'])->name('login');
Route::post('/log-in', [AuthController::class, 'post'])->name('post.login');

Route::group([
    'prefix' => '/admin',
    'as' => 'admin.',
], function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::group([
        'prefix' => '/expenses',
        'as' => 'expenses.',
    ], function () {
        Route::get('/', [ExpensesController::class, 'index'])->name('index');
        Route::get('/add-expenses', [ExpensesController::class, 'add'])->name('add');
    });

    Route::group([
        'prefix' => '/debt',
        'as' => 'debt.',
    ], function () {
        Route::get('/', [DebtController::class, 'index'])->name('index');
        Route::get('/add-debt', [DebtController::class, 'add'])->name('add');
    });

    Route::group([
        'prefix' => '/jobs',
        'as' => 'jobs.',
    ], function () {
        Route::get('/active-jobs', [JobsController::class, 'active'])->name('active');
        Route::get('/on-hold-jobs', [JobsController::class, 'pause'])->name('pause');
        Route::get('/finished-jobs', [JobsController::class, 'finished'])->name('finished');
        Route::get('/canceled-jobs', [JobsController::class, 'canceled'])->name('canceled');
        Route::get('/add-jobs', [JobsController::class, 'add'])->name('add');
    });
});
