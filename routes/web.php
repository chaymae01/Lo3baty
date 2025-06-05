<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

require __DIR__ . '/partenaire.php';
require __DIR__ . '/client.php';
require __DIR__ . '/admin.php';