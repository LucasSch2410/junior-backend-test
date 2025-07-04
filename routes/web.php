<?php

use App\Http\Controllers\ContactsController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::resource('contacts', ContactsController::class)->only(['index','store','update','destroy']);
