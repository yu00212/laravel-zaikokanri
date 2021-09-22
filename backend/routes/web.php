<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StockController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuestController;

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

Route::get('/home', function () {
    return view('home');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('redirects', 'App\Http\Controllers\LoginController@index');

//ゲストユーザーログイン
Route::get('/guest', 'App\Http\Controllers\LoginController@guestLogin')->name('guest.login');

Route::group(['middleware' => ['auth', 'can:guest']], function () {
    //ゲスト在庫一覧
    Route::get('/guest/list', [GuestController::class, 'index'])->name('guest.home');

    //在庫詳細
    Route::get('/guest/list/show/{id}', [GuestController::class, 'show']);

    //在庫追加
    Route::get('/guest/list/add', [GuestController::class, 'add']);
    Route::post('/guest/list/addCheck', [GuestController::class, 'addCheck']);
    Route::post('/guest/list/addDone', [GuestController::class, 'addDone']);

    //在庫編集
    Route::get('/guest/list/edit/{id}',[GuestController::class, 'edit']);
    Route::post('/guest/list/edit/{id}',[GuestController::class, 'edit']);
    Route::post('/guest/list/editCheck/{id}',[GuestController::class, 'editCheck']);
    Route::post('/guest/list/editDone/{id}',[GuestController::class, 'editDone']);

    //在庫削除
    Route::get('/guest/list/delCheck/{id}', [GuestController::class, 'delCheck']);
    Route::post('/guest/list/delDone/{id}',[GuestController::class, 'delDone']);

    //在庫検索
    Route::get('/guest/list/search', [GuestController::class, 'search']);
    Route::post('/guest/list/search', [GuestController::class, 'search']);
});

// 全ユーザ
Route::group(['middleware' => ['auth', 'can:user-higher']], function () {
    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/Userdashboard', function () {
        return view('dashboard');
    })->name('user-dashboard');

    //在庫一覧
    Route::get('/list', [StockController::class, 'index'])->name('home');

    //在庫詳細
    Route::get('/list/show/{id}', [StockController::class, 'show']);

    //在庫追加
    Route::get('/list/add', [StockController::class, 'add']);
    Route::post('/list/addCheck', [StockController::class, 'addCheck']);
    Route::post('/list/addDone', [StockController::class, 'addDone']);

    //在庫編集
    Route::get('/list/edit/{id}',[StockController::class, 'edit']);
    Route::post('/list/edit/{id}',[StockController::class, 'edit']);
    Route::post('/list/editCheck/{id}',[StockController::class, 'editCheck']);
    Route::post('/list/editDone/{id}',[StockController::class, 'editDone']);

    //在庫削除
    Route::get('/list/delCheck/{id}', [StockController::class, 'delCheck']);
    Route::post('/list/delDone/{id}',[StockController::class, 'delDone']);

    //在庫検索
    Route::get('/list/search', [StockController::class, 'search']);
    Route::post('/list/search', [StockController::class, 'search']);
});

// 管理者以上
Route::group(['middleware' => ['auth', 'can:admin-higher']], function () {
    Route::middleware(['auth:sanctum', 'verified'])->get('/Admindashboard', function () {
        return view('dashboard');
    })->name('admin-dashboard');

    //在庫一覧
    Route::get('/admin/list', [AdminController::class, 'index'])->name('admin-home');

    //在庫詳細
    Route::get('/admin/list/show/{id}', [AdminController::class, 'show']);

    //在庫削除
    Route::get('/admin/list/delCheck/{id}', [AdminController::class, 'delCheck']);
    Route::post('/admin/list/delDone/{id}',[AdminController::class, 'delDone']);

    //在庫検索
    Route::get('/admin/list/search', [AdminController::class, 'search']);
    Route::post('/admin/list/search', [AdminController::class, 'search']);

    //アカウント一覧
    Route::get('/admin/userList', [AdminController::class, 'userIndex'])->name('user-list');

    //アカウント削除
    Route::get('/admin/userList/delCheck/{id}', [AdminController::class, 'userDelCheck']);
    Route::post('/admin/userList/delDone/{id}',[AdminController::class, 'userDelDone']);

    //アカウント検索
    Route::get('/admin/userList/search', [AdminController::class, 'userSearch']);
    Route::post('/admin/userList/search', [AdminController::class, 'userSearch']);
});
