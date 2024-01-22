<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/bootstrap', function () {
    return view('bootstrap');
})->name('bootstrap');

// Route::get('/spam', function () {
//     do {
//         $fake = fake()->name();
//         $url = "https://api.telegram.org/bot6852739481:AAEODLj8ikhz3HHHef7RdTB2nL5VJxrE6xo/sendMessage?parse_mode=markdown&chat_id=6723234237&text=Halo $fake";
//         $res = Http::post($url);

//         Log::debug($url);
//         Log::debug($res->body());
//     } while (true);
// });

Route::middleware('guest')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('/login', 'login')->name('login');
        Route::post('/login', 'doLogin');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('can:role,"admin"')->name('logout');

    Route::resource('items', ItemController::class);
});

