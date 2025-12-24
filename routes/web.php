<?php

use App\Http\Controllers\MenuController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

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

Route::get('/food', [MenuController::class, 'index']);
Route::get('/food/create', [MenuController::class, 'create']);
Route::post('/food', [MenuController::class, 'store']);

Route::get('/food/{id}/edit', [MenuController::class, 'edit']);
Route::put('/food/{id}', [MenuController::class, 'update']);
Route::delete('/food/{id}', [MenuController::class, 'destroy']);

Route::get('/transaksi', [TransactionController::class, 'index']);
Route::post('/transactions', [TransactionController::class, 'store']);
