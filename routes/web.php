<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\CategoryController;

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
    return view('welcome');
});

Auth::routes();

// 
// // handle redirect register to login
// Route::match(['get', 'post'], '/register', function () {
//     return redirect('/login');
// });
// 


// Route Middleware
Route::middleware('auth')->group(function () {

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('/profile', [App\Http\Controllers\Profile\ProfileController::class, 'index'])->name('profile.index');

    // Route for admin
    Route::middleware(['auth', 'admin'])->group(function () {

        //Route for News using Resource
        Route::resource('news', NewsController::class);
        
        // Route for Category using Resource
        // Fungsi except('show') itu untuk menghilangkan function karena kita tidak menggunakan show
        // Fungsi only('index') itu untuk menampilkan fungsi index saja kerana kita hanya menggunakan index
        Route::resource('category', CategoryController::class)->except('show');

    });

});
