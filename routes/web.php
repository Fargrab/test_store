<?php

use App\Http\Controllers\CatalogController;
use App\Http\Controllers\OrderController;
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

Route::get('/catalog', [CatalogController::class, 'getAllProducts'])->name('get-catalog');
Route::post('/create-order', [OrderController::class, 'setOrder'])->name('set-order');
Route::post('/approve-order', [OrderController::class, 'approveOrder'])->name('approve-order');
