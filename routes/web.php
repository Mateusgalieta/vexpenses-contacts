<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfilesController;

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
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/profile', [App\Http\Controllers\ProfilesController::class, 'index'])->name('profile');
Route::post('/profile/update', [App\Http\Controllers\ProfilesController::class, 'update'])->name('profile.update');

//Users Routes
Route::get('/users', [App\Http\Controllers\UsersController::class, 'index'])->name('user.index');
Route::get('/users/register', [App\Http\Controllers\UsersController::class, 'register'])->name('user.register');
Route::post('/users/create', [App\Http\Controllers\UsersController::class, 'create'])->name('user.create');
Route::get('/users/{id}/edit', [App\Http\Controllers\UsersController::class, 'edit'])->name('user.edit');
Route::put('/users/{id}/update', [App\Http\Controllers\UsersController::class, 'update'])->name('user.update');
Route::get('/users/{id}/delete', [App\Http\Controllers\UsersController::class, 'destroy'])->name('user.destroy');


//Departments Routes
Route::get('/departments', [App\Http\Controllers\DepartmentsController::class, 'index'])->name('department.index');
Route::get('/departments/register', [App\Http\Controllers\DepartmentsController::class, 'register'])->name('department.register');
Route::post('/departments/create', [App\Http\Controllers\DepartmentsController::class, 'create'])->name('department.create');
Route::get('/departments/{id}/edit', [App\Http\Controllers\DepartmentsController::class, 'edit'])->name('department.edit');
Route::put('/departments/{id}/update', [App\Http\Controllers\DepartmentsController::class, 'update'])->name('department.update');
Route::get('/departments/{id}/delete', [App\Http\Controllers\DepartmentsController::class, 'destroy'])->name('department.destroy');

//Categories Routes
Route::get('/categories', [App\Http\Controllers\CategoriesController::class, 'index'])->name('category.index');
Route::get('/categories/register', [App\Http\Controllers\CategoriesController::class, 'register'])->name('category.register');
Route::post('/categories/create', [App\Http\Controllers\CategoriesController::class, 'create'])->name('category.create');
Route::get('/categories/{id}/edit', [App\Http\Controllers\CategoriesController::class, 'edit'])->name('category.edit');
Route::put('/categories/{id}/update', [App\Http\Controllers\CategoriesController::class, 'update'])->name('category.update');
Route::get('/categories/{id}/delete', [App\Http\Controllers\CategoriesController::class, 'destroy'])->name('category.destroy');

//Contacts Routes
Route::get('/contacts', [App\Http\Controllers\ContactsController::class, 'index'])->name('contact.index');
Route::get('/contacts/register', [App\Http\Controllers\ContactsController::class, 'register'])->name('contact.register');
Route::post('/contacts/create', [App\Http\Controllers\ContactsController::class, 'create'])->name('contact.create');
Route::get('/contacts/{id}/edit', [App\Http\Controllers\ContactsController::class, 'edit'])->name('contact.edit');
Route::put('/contacts/{id}/update', [App\Http\Controllers\ContactsController::class, 'update'])->name('contact.update');
Route::get('/contacts/{id}/delete', [App\Http\Controllers\ContactsController::class, 'destroy'])->name('contact.destroy');
