<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;

Route::post('/bookings/create', [BookingController::class, 'createBooking']);