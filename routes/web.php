<?php

use App\Http\Controllers\MinistryController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\DepartmentController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        // 'laravelVersion' => Application::VERSION,
        // 'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::controller(PersonController::class)->group(function() {
    Route::get('/person', 'index')->name('person.index');
    Route::get('/person/{person}', 'show')->name('person.show');
});

Route::controller(MinistryController::class)->group(function() {
    Route::get('/institution', 'index')->name('institution.index');
    Route::get('/institution/{ministry}', 'show')->name('institution.show');
});

Route::controller(DepartmentController::class)->group(function() {
    Route::get('/unit', 'index')->name('unit.index');
    Route::get('/unit/{unit}', 'show')->name('unit.show');
});


require __DIR__.'/auth.php';
