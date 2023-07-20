<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GeneratorController;
use App\Http\Controllers\StudentController;
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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [UserController::class, 'showLogin'])->name('login');
Route::get('login', [UserController::class, 'showLogin'])->name('login');
Route::post('login', [UserController::class, 'login']);
Route::get('register', [UserController::class, 'create'])->name('register');
Route::post('register', [UserController::class, 'store']);


Route::group(['middleware' => 'auth'], function () {

    Route::get('logout', [UserController::class, 'logout'])->name('logout');
    Route::get('/dashboards', [DashboardsController::class, 'index'])->name('dashboards');
    Route::get('/getData', [DashboardsController::class, 'getData'])->name('getData');
    Route::resource('users', UserController::class);
    Route::resource('generators', GeneratorController::class);
    Route::resource('students', StudentController::class);
    Route::get('listAnswer', [StudentController::class, 'indexSiswa'])->name('listAnswer');
    
    Route::post('cekAnswer', [GeneratorController::class, 'cekAnswer'])->name('cekAnswer');
    Route::get('getAnswer/{jawaban}/{pertanyaan}', [GeneratorController::class, 'getDataAnswer'])->name('getAnswer');
    Route::post('/students', [StudentController::class, 'store'])->name('students.store');
});


