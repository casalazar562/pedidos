<?php

use App\Http\Controllers\Api\V1\CuentaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('counts', [CuentaController::class, 'all'])->name('get.all.counts');
Route::post('create/count', [CuentaController::class, 'create'])->name('post.create.count');
Route::put('update/count/{id}', [CuentaController::class, 'update'])->name('put.update.count'); 
Route::get('find/count/{id}', [CuentaController::class, 'find'])->name('get.count'); 
Route::delete('delete/count/{id}', [CuentaController::class, 'delete'])->name('delete.count');