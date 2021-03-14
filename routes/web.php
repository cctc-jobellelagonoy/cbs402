<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Posts;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
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

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/post', Posts::class)->name('post');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/forgot-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'index'])->name('forgot-password');
Route::post('/forgot-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'index'])->name('forgot-password');

Route::get('/reset-password', [App\Http\Controllers\Auth\ResetPasswordController::class, 'index'])->name('reset-password');
Route::post('/reset-password', [App\Http\Controllers\Auth\ResetPasswordController::class, 'index'])->name('reset-password');
