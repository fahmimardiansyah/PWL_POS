<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\LogoutController;
use App\Http\Controllers\Api\LevelController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\KategoriController;
use App\Http\Controllers\Api\BarangController;
use App\Http\Controllers\Api\PenjualanController;
use App\Http\Controllers\Api\DetailController;
use App\Http\Controllers\Controller;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post("/register", App\Http\Controllers\Api\RegisterController::class)->name('register');
Route::post("/register1", App\Http\Controllers\Api\RegisterController::class)->name('register1');
Route::post("/login", App\Http\Controllers\Api\LoginController::class)->name('login');
Route::post("/logout", App\Http\Controllers\Api\LogoutController::class)->name('logout');
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'levels'], function () {
    Route::get('/', [LevelController::class, 'index']);
    Route::post('/', [LevelController::class, 'store']);
    Route::get('/{level}', [LevelController::class, 'show']);
    Route::put('/{level}', [LevelController::class, 'update']);
    Route::delete('/{level}', [LevelController::class, 'destroy']);
});

Route::group(['prefix' => 'users'], function () {
    Route::get('/', [UserController::class, 'index']);
    Route::post('/', [UserController::class, 'store']);
    Route::get('/{user}', [UserController::class, 'show']);
    Route::put('/{user}', [UserController::class, 'update']);
    Route::delete('/{user}', [UserController::class, 'destroy']);
});

Route::group(['prefix' => 'kategori'], function () {
    Route::get('/', [KategoriController::class, 'index']);
    Route::post('/', [KategoriController::class, 'store']);
    Route::get('/{kategori}', [KategoriController::class, 'show']);
    Route::put('/{kategori}', [KategoriController::class, 'update']);
    Route::delete('/{kategori}', [KategoriController::class, 'destroy']);
});

Route::group(['prefix' => 'barang'], function () {
    Route::get('/', [BarangController::class, 'index']);
    Route::post('/', [BarangController::class, 'store']);
    Route::get('/{barang}', [BarangController::class, 'show']);
    Route::put('/{barang}', [BarangController::class, 'update']);
    Route::delete('/{barang}', [BarangController::class, 'destroy']);
});

Route::group(['prefix' => 'penjualan'], function () {
    Route::get('/', [PenjualanController::class, 'index']);
    Route::post('/', [PenjualanController::class, 'store']);
    Route::get('/{penjualan}', [PenjualanController::class, 'show']);
    Route::put('/{penjualan}', [PenjualanController::class, 'update']);
    Route::delete('/{penjualan}', [PenjualanController::class, 'destroy']);
});

Route::group(['prefix' => 'detail'], function () {
    Route::get('/', [DetailController::class, 'index']);
    Route::post('/', [DetailController::class, 'store']);
    Route::get('/{detail}', [DetailController::class, 'show']);
    Route::put('/{detail}', [DetailController::class, 'update']);
    Route::delete('/{detail}', [DetailController::class, 'destroy']);
});