<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); //ログイン者のみ下記メソッドを実行可能に
    }

    //在庫一覧画面
    public function index(Request $request)
    {
        $stocks = Stock::query()->simplePaginate(6); //全在庫取得
        $count = 0;
        $keyword = $request->input('search');
        return view('stock.list', ['keyword' => $keyword, 'count' => $count, 'stocks' => $stocks]);
    }

    //アカウント一覧画面
    public function userIndex(Request $request)
    {
        $users = User::query()->simplePaginate(6); //全アカウント取得
        $count = 0;
        $keyword = $request->input('search');
        return view('admin.userList', ['keyword' => $keyword, 'count' => $count, 'users' => $users]);
    }

    //在庫検索
    public function search(Request $request)
    {
        $keyword = $request->input('search');

        if (empty($keyword)) {
            $count = 0;
            $keyword = '';
            $err = 'キーワードが入力されていません。';
            $param = ['keyword' => $keyword, 'err' => $err, 'count' => $count];
            return view('stock.list', $param);
        }

        $stocks = Stock::where('name', 'like', "%{$keyword}%")->simplePaginate(6);
        $count = $stocks->count();
        $param = ['keyword' => $keyword, 'stocks' => $stocks, 'count' => $count];
        return view('stock.list', $param);
    }

    //在庫詳細画面
    public function show($id)
    {
        $stock = Stock::find($id);
        return view('stock.show', ['stock' => $stock]);
    }

    //在庫削除確認
    public function delCheck($id)
    {
        $stock = Stock::find($id); //idによるレコード検索
        return view('stock.delCheck', ['stock' => $stock]);
    }

    //在庫削除DB反映
    public function delDone($id)
    {
        Stock::find($id)->delete();
        return redirect('/admin/list');
    }

    //アカウント検索
    public function userSearch(Request $request)
    {
        $keyword = $request->input('search');

        if (empty($keyword)) {
            $count = 0;
            $keyword = '';
            $err = 'キーワードが入力されていません。';
            $param = ['keyword' => $keyword, 'err' => $err, 'count' => $count];
            return view('admin.userList', $param);
        }

        $users = User::where('name', 'like', "%{$keyword}%")->simplePaginate(6);
        $count = $users->count();
        $param = ['keyword' => $keyword, 'users' => $users, 'count' => $count];
        return view('admin.userList', $param);
    }

    //アカウント削除確認
    public function userDelCheck($id)
    {
        $user = User::find($id);
        return view('/admin.userDelCheck', ['user' => $user]);
    }

    //アカウント削除DB反映
    public function userDelDone($id)
    {
        User::find($id)->delete();
        return redirect('/admin/userList');
    }
}
