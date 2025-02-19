<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetController; //import controller
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pets', [PetController::class, 'index'])->name('pets.index');
Route::get('/pet-list', [PetController::class, 'getPet'])->name('pets.getPet');

// Create function
Route::get('/pets/create', [PetController::class, 'create'])->name('pets.create');
Route::post('/pets', [PetController::class, 'store'])->name('pets.store');

// Edit and Update route
Route::get('/pets/{id}/edit', [PetController::class, 'edit'])->name('pets.edit');
Route::put('/pets/{id}', [PetController::class, 'update'])->name('pets.update');

// Delete function
Route::delete('/pets/{id}', [PetController::class, 'destroy'])->name('pets.destroy');



Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('home');
