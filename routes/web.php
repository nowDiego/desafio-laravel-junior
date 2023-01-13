<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PurshaseOrderController;

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

Route::get('/',[AuthController::class,'index'])->name('login.index'); 



Route::get('/login',[AuthController::class,'index'])->name('login.index'); 

Route::post('/login',[AuthController::class,'login'])->name('login'); 

Route::get('/logout',[AuthController::class,'logout'])->name('logout'); 

Route::group(['middleware' => 'auth'], function () {


Route::resource('customer', CustomerController::class);

Route::resource('product', ProductController::class);

Route::resource('PurshaseOrder', PurshaseOrderController::class);

Route::get('/dashboard', function () {
    return view('Dashboard.index');
});


});