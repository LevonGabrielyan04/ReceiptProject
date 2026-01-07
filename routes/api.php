<?php

use Illuminate\Support\Facades\Route;

Route::post('/convert', [\App\Http\Controllers\ReceiptController::class, 'convert']);
