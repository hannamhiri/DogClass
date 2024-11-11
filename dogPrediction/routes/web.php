<?php

use App\Http\Controllers\HyperparametreController;
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

Route::get('/', function () {
    return view('welcome');
});


Route::resource('hyperparametre', \App\Http\Controllers\HyperparametreController::class);
Route::get('/index', function () {
    return view('index');
});

Route::get('/history', [HyperparametreController::class, 'history'])->name('training.history');
Route::get('/hyperparametres', [HyperparametreController::class, 'showHyper'])->name('hyper.display');
Route::get('/images', [HyperparametreController::class, 'showDoss'])->name('doss.display');

