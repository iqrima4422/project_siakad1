<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\MahasiswaController;
use Illuminate\Http\Request;
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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('mahasiswa', MahasiswaController::class);

Route::get('/khs/{nim}', [MahasiswaController::class, 'khs'])->name('khs');

Route::get('/cari', [MahasiswaController::class, 'cari'])->name('cari');


Route::get('/mahasiswa/khs/cetak_pdf/{nim}', [MahasiswaController::class, 'cetak_pdf'])->name('cetak_pdf');

// Praktikum 10 - Unggah Berkas dan Eksport PDF
Route::resource('articles', ArticleController::class);

Route::get('/article/cetak_pdf', [ArticleController::class, 'cetak_pdf']);