<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetController; //import controller
use App\Http\Controllers\ReaderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TypeController;
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
// group by role type
Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/pets', [PetController::class, 'index'])->name('pets.index');
    Route::get('/pet-list', [PetController::class, 'getPet'])->name('pets.getPet');

    // ADD PET
    Route::get('/pets/create', [PetController::class, 'create'])->name('pets.create');
    Route::post('/pets', [PetController::class, 'store'])->name('pets.store');

    //FETCH TYPE AND BREEDS
    Route::get('/types/fetch', [TypeController::class, 'fetchTypes'])->name('types.fetch');
    Route::get('/types/fetch-breeds', [TypeController::class, 'fetchBreeds'])->name('types.fetchBreeds');


    // EDIT AND UPDATE PET
    Route::put('/pets/{id}', [PetController::class, 'update'])->name('pets.update');


    // DELETE PET
    Route::delete('/pets/{id}', [PetController::class, 'destroy'])->name('pets.destroy');

    // USER ROLE
    Route::get('/user-dashboard', [UserController::class, 'index'])->name('user.dashboard');

    // READER ROLE
    Route::get('/reader-dashboard', [ReaderController::class, 'index'])->name('reader.dashboard');

    // Admin Dashboard Route
    // Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');


    // MANAGE PET TYPE
    Route::get('/pets/manage', [TypeController::class, 'index'])->name('pets.manage');
    Route::get('/types/list', [TypeController::class, 'list']);
    Route::post('/types', [TypeController::class, 'store']);
    Route::delete('/types/{id}', [TypeController::class, 'destroy']);
    Route::put('/types/{id}', [TypeController::class, 'update']);


});


Auth::routes(['verify' => true]);
Route::get('/home', [HomeController::class, 'index'])->name('home');
