<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HomologationController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function () {
    Route::get('login', LoginController::getAction('index'));
    Route::post('login', LoginController::getAction('login'))->name('login');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', HomeController::getAction('index'))->name('home');
    Route::get('/homologation', HomologationController::getAction('index'))->name('homologation');
    Route::post('/homologation/start', HomologationController::getAction('start'))->name('homologation.start');
    Route::get('/homologation/check', HomologationController::getAction('check'))->name('homologation.check');
});
