<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\ValidateRequest;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct() { // __construct クラスを追加
        $this->middleware('auth'); //ログイン者のみ下記メソッドを実行可能に
    }

    //在庫一覧表示
    public function index(Request $request)
    {
        $stocks = Stock::query()->simplePaginate(6); //全在庫取得
        return view('stock.list', ['stocks' => $stocks]);
    }

    //アカウント一覧表示
    public function userIndex(Request $request)
    {
        $users = User::query()->simplePaginate(6); //全アカウント取得
        return view('admin.userList', ['users' => $users]);
    }

    //在庫検索
    public function search(Request $request)
    {
        $keyword = $request->input('search');

        if(!empty($keyword)) {
            $stocks = Stock::where('name', 'like', "%{$keyword}%")->simplePaginate(6);
            $count = $stocks->count();
            $param = ['keyword' => $keyword, 'stocks' => $stocks, 'count' => $count];
            return view('stock.search', $param);
        } elseif(empty($keyword)) {
            $count = 0;
            $keyword = '';
            $err = 'キーワードが入力されていません。';
            $param = ['keyword' => $keyword, 'err' => $err, 'count' => $count];
            return view('stock.search', $param);
        }
    }

    //在庫詳細表示
    public function show(Request $request,$id)
    {
        $stock = Stock::find($id);
        return view('stock.show', ['stock' => $stock]);
    }

    //在庫削除確認
    public function delCheck(Request $request,$id)
    {
        $stock = Stock::find($id); //idによるレコード検索
        return view('stock.delCheck', ['stock' => $stock]);
    }

    //在庫削除DB反映
    public function delDone(Request $request,$id)
    {
        Stock::find($id)->delete();
        return redirect('/admin/list');
    }

    //アカウント検索
    public function userSearch(Request $request)
    {
        $keyword = $request->input('search');

        if(!empty($keyword)) {
            $users = User::where('name', 'like', "%{$keyword}%")->simplePaginate(6);
            $count = $users->count();
            $param = ['keyword' => $keyword, 'users' => $users, 'count' => $count];
            return view('admin.userSearch', $param);
        } elseif(empty($keyword)) {
            $count = 0;
            $keyword = '';
            $err = 'キーワードが入力されていません。';
            $param = ['keyword' => $keyword, 'err' => $err, 'count' => $count];
            return view('admin.userSearch', $param);
        }
    }

    //アカウント削除確認
    public function userDelCheck(Request $request,$id)
    {
        $user = User::find($id);
        return view('/admin.userDelCheck', ['user' => $user]);
    }

    //アカウント削除DB反映
    public function userDelDone(Request $request,$id)
    {
        USer::find($id)->delete();
        return redirect('/admin/userList');
    }

}
