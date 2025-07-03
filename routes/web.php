<?php

use App\Http\Controllers\CreateContactController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Contacts');
});

Route::post('/contacts', CreateContactController::class);
