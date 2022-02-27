<?php

use App\Http\Controllers\OrdersController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/checkout', [TransactionController::class, 'Payment'])
    ->name('payment.checkout');

Route::get('/success', [TransactionController::class, 'Success'])
    ->name('payment.success');

Route::get('/failed', [TransactionController::class, 'Failed'])
    ->name('payment.failed');

Route::get('/admin', [OrdersController::class, 'Index']);
Route::get('/admin/AJAX', [OrdersController::class, 'Show'])
    ->name('admin.orders');
