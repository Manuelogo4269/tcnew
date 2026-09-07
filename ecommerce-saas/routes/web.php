<?php

use Illuminate\Support\Facades\Route;

Route::domain('localhost')->get('/', function () {
    return view('central.home');
});

Route::domain('127.0.0.1')->get('/', function () {
    return view('central.home');
});
