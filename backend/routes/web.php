<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StockController;
use App\Http\Controllers\AdminController;

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

/**
* ルーティング（管理者・利用者）
*/
foreach(config('fortify.users') as $user){
    Route::prefix($user)
    ->namespace('\Laravel\Fortify\Http\Controllers')
    ->name($user.'.')
    ->group(function () use($user) {
        /**
        * ログイン 画面
        * @method GET
        */
        Route::name('login')->middleware('guest')
        ->get('/login', 'AuthenticatedSessionController@create');
        /**
        * ログイン 認証
        * @method POST
        */
        Route::name('login')->middleware(['guest', 'throttle:'.config('fortify.limiters.login')])
        ->post('/login', 'AuthenticatedSessionController@store');
        /**
        * ログアウト
        * @method POST
        */
        Route::name('logout')->middleware('guest')
        ->post('/logout', 'AuthenticatedSessionController@destroy');
        /**
        * ダッシュボード
        * @method GET
        */
        Route::name('dashboard')->middleware(['auth:'.\Str::plural($user), 'verified'])
        ->get('/dashboard', function () use($user) {
            return view($user.'.dashboard');
        });
    });
}

Route::get('/', function () {
    return view('welcome');
});

//Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    //return view('dashboard');
//})->name('dashboard');

Route::get('user/list', [StockController::class, 'index'])->name('home');
Route::get('admin/list', [AdminController::class, 'index'])->name('admin-home');

Route::get('admin/userList', [AdminController::class, 'userList'])->name('admin-home');

Route::get('user/list/show/{id}', [StockController::class, 'show']);
Route::get('admin/list/show/{id}', [AdminController::class, 'show']);

Route::get('user/list/add', [StockController::class, 'add']);
Route::post('user/list/addCheck', [StockController::class, 'addCheck']);
Route::post('user/list/addDone', [StockController::class, 'addDone']);

Route::get('user/list/edit/{id}',[StockController::class, 'edit']);
Route::post('user/list/edit/{id}',[StockController::class, 'editReturn']);
Route::post('user/list/editCheck/{id}',[StockController::class, 'editCheck']);
Route::post('user/list/editDone/{id}',[StockController::class, 'editDone']);

Route::get('user/list/delCheck/{id}', [StockController::class, 'delCheck']);
Route::post('user/list/delDone/{id}',[StockController::class, 'delDone']);
Route::get('admin/list/delCheck/{id}', [AdminController::class, 'delCheck']);
Route::post('admin/list/delDone/{id}',[AdminController::class, 'delDone']);

Route::get('user/list/search', [StockController::class, 'search']);
Route::post('user/list/search', [StockController::class, 'search']);
Route::get('admin/list/search', [AdminController::class, 'search']);
Route::post('admin/list/search', [AdminController::class, 'search']);


