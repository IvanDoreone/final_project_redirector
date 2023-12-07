<?php

use App\Http\Controllers\MainController;
use App\Http\Controllers\MyResourcesController;
use App\Http\Controllers\OffersController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResourseController;
use Illuminate\Support\Facades\Route;


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
Route::get('tests', 'MainController@tests') -> name('tests');
Route::get('redirector', 'MainController@redirector') -> name('redirector');

Route::get('welcome', 'MainController@welcome') -> name('welcome')->middleware(['logg:test','auth']);

Route::get('analitics_client', 'MainController@analitics_client') -> name('analitics_client')->middleware(['auth']);
Route::get('analitics_webmaster', 'MainController@analitics_webmaster') -> name('analitics_webmaster')->middleware(['auth']);
Route::get('analitics_admin', 'MainController@analitics_admin') -> name('analitics_admin')->middleware(['auth']);
Route::get('offers_admin', 'MainController@offers_admin') -> name('offers_admin')->middleware(['auth']);
Route::post('offers_admin', 'MainController@offers_control_ajax')->middleware(['auth']);
Route::get('offers_control', 'MainController@offers_control') -> name('offers_control')->middleware(['auth']);
Route::post('offers_control', [OffersController::class, 'create'])->middleware(['auth']);

Route::post('offers_delete_ajax', 'MainController@offers_delete_ajax') -> name('offers_delete_ajax')->middleware(['auth']);

Route::post('offers_post_new', 'MainController@offers_post_new') -> name('offers_post_new')->middleware(['auth']);
Route::get('resources_admin', 'MainController@resources_admin') -> name('resources_admin')->middleware(['auth']);
Route::post('resources_admin', 'MainController@resources_control_ajax')->middleware(['auth']);
Route::get('resources_control', 'MainController@resources_control') -> name('resources_control')->middleware(['auth']);
Route::post('resources_control_ajax', 'MainController@resources_controlajax') -> name('resources_control_ajax')->middleware(['auth']);
Route::post('resourse_post_new_ajax', 'MainController@resourse_post_new_ajax') -> name('resourse_post_new_ajax')->middleware(['auth']);
Route::post('resource_delete_ajax', 'MainController@resource_delete_ajax') -> name('resource_delete_ajax')->middleware(['auth']);

Route::get('users_admin', 'MainController@users_admin') -> name('users_admin')->middleware(['auth']);
Route::get('users_control', 'MainController@users_admin_control') -> name('users_admin_control')->middleware(['auth']);
Route::post('users_control', 'MainController@users_admin_control_ajax') -> name('users_admin_control_ajax')->middleware(['auth']);
Route::resource('news' , ResourseController::class);


Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', 'verified']);

/* Route::get('/', function () {
    return view('welcome');
}); */

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::resource('news' , ResourseController::class);
    Route::resource('offers' , OffersController::class);
    Route::resource('my_resources' , MyResourcesController::class);
    Route::get('my_subscribes/control', 'MainController@control_subscribes');
    Route::post('control_subscribes_ajax', 'MainController@control_subscribes_ajax');
    Route::post('my_subscribes/delete', 'MainController@delete_subscribes');
    Route::post('my_subscribes_delete_ajax', 'MainController@my_subscribes_delete_ajax');

    Route::get('my_subscribes', 'MainController@my_subscribes') -> name('my_subscribes');
    Route::get('all_offers', 'MainController@all_offers') -> name('all_offers');
    Route::get('my_resources', 'MainController@my_resources') -> name('my_resources');
    Route::get('/news', [ResourseController::class, 'index'])->name('news');
    Route::get('/offers', [OffersController::class, 'index'])->name('offers');
    Route::get('/my_resources', [MyResourcesController::class, 'index'])->name('my_resources');
    Route::get('offer_subscribe', [MainController::class, 'offer_subscribe'])->name('offer_subscribe');
    Route::post('offer_subscribe_ajax', [MainController::class, 'offer_subscribe_ajax'])->name('offer_subscribe_ajax');
    Route::get('news_control', [MainController::class, 'news_control'])->name('news_control');
});

require __DIR__.'/auth.php';
