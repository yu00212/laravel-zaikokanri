<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StockController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SystemController;
use Laravel\Jetstream\Http\Controllers\Livewire\UserProfileController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;
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

//Route::get('/top', function () {
    //return view('top');
//});

Route::get('redirects', 'App\Http\Controllers\LoginController@index');

// 全ユーザ
Route::group(['middleware' => ['auth', 'can:user-higher']], function () {
    /**
    * ルーティング（管理者・利用者）
    */
    //foreach(config('fortify.users') as $user){
        //Route::prefix($user)
        //->namespace('\Laravel\Fortify\Http\Controllers')
        //->name($user.'.')
        //->group(function () use($user) {
            /**
            * ログイン 画面
            * @method GET
            */
            //Route::name('login')->middleware('guest')
            //->get('/login', 'AuthenticatedSessionController@create');
            /**
            * ログイン 認証
            * @method POST
            */
            //Route::name('login')->middleware(['guest', 'throttle:'.config('fortify.limiters.login')])
            //->post('/login', 'AuthenticatedSessionController@store');
            /**
            * ログアウト
            * @method POST
            */
            //Route::name('logout')->middleware('guest')
            //->post('/logout', 'AuthenticatedSessionController@destroy');
            /**
            * ダッシュボード
            * @method GET
            */
            //Route::name('dashboard')->middleware(['auth:'.\Str::plural($user), 'verified'])
            //->get('/dashboard', function () use($user) {
                //return view($user.'.dashboard');
            //});
        //});

    Route::get('/', function () {
        return view('welcome');
    });

    //Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard?user', function () {
        //return view('dashboard');
    //})->name('user-dashboard');

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
    Route::post('/list/edit/{id}',[StockController::class, 'editReturn']);
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
