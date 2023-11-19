<?php

use App\Http\Controllers\Api\V1\CuentaController;
use App\Http\Controllers\Api\V1\PedidoController;
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

/**
 * rutas cuenta
 */
Route::get('counts', [CuentaController::class, 'all'])->name('get.all.counts');
Route::post('create/count', [CuentaController::class, 'create'])->name('post.create.count');
Route::put('update/count/{id}', [CuentaController::class, 'update'])->name('put.update.count'); 
Route::get('find/count/{id}', [CuentaController::class, 'find'])->name('get.count'); 
Route::delete('delete/count/{id}', [CuentaController::class, 'delete'])->name('delete.count');

/**
 * rutas pedido
 */

 Route::get('order', [PedidoController::class, 'all'])->name('get.all.order');
 Route::post('create/order', [PedidoController::class, 'create'])->name('post.create.order');
 Route::put('update/order/{id}', [PedidoController::class, 'update'])->name('put.update.order'); 
 Route::get('find/order/{id}', [PedidoController::class, 'find'])->name('get.order'); 
 Route::delete('delete/order/{id}', [PedidoController::class, 'delete'])->name('delete.order');