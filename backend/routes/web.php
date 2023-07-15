<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();


Route::group(['middleware' => ['auth']], function() {
    
    // Route::get('/','Admin\DashboardController@dashboard')->name('dashboard');
    
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    
    Route::resource('category',App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('sub-category',App\Http\Controllers\Admin\SubCategoryController::class);
    Route::resource('pdf-upload',App\Http\Controllers\Admin\PdfUploadController::class);
    
});

/** Running */
Route::GET('cache-clear',function(){
    Artisan::call('optimize:clear');
    echo "Call the artisan optimize:clear";
});