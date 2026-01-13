<?php

use App\Http\Controllers\DebtController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\JobsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/new-jobs', [JobsController::class, 'store']);
Route::post('/finish-jobs', [JobsController::class, 'finish']);
Route::post('/pause-jobs', [JobsController::class, 'paused']);
Route::post('/start-jobs', [JobsController::class, 'start']);
Route::post('/cancel-jobs', [JobsController::class, 'cancel']);
Route::post('/new-expenses', [ExpensesController::class, 'store']);
Route::post('/delete-expenses', [ExpensesController::class, 'delete']);
Route::post('/new-debt', [DebtController::class, 'store']);
Route::post('/delete-debts', [DebtController::class, 'delete']);
