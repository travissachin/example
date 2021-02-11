<?php

use App\Models\Role;
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
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    $role_name= Role::find(auth()->user()->role_id)->name;
    return Inertia::render('Dashboard', ['role'=> $role_name]);
})->name('dashboard');

Route::group(['middleware'=> ['auth:sanctum', 'verified','roles: admin'], 'prefix' => 'admin', 'name'=> 'admin'], function(){
    Route::get('/dashboard', function () {
        $role_name= Role::find(auth()->user()->role);
        return Inertia::render('Dashboard',['role'=> $role_name]);
    })->name('dashboard');
});


