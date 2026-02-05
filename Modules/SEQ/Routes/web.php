<?php

use Illuminate\Support\Facades\Route;
use Modules\SEQ\Http\Controllers\SEQController;

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

Route::prefix('seq')->group(function() {
    Route::get('/index', [SEQController::class, 'index'])->name('cefa.seq.index');
});
