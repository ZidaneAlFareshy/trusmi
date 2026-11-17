<?php

use App\Http\Controllers\KpiController;
use Illuminate\Support\Facades\Route;

Route::get('/', [KpiController::class, 'index']);