<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\ValidateRequest;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct() { //  __construct クラスを追加
        $this->middleware('auth'); // ログイン者のみ下記メソッドを実行可能に
    }

    public function index(Request $request)
    {
        $stocks = Stock::query()->simplePaginate(8); //全在庫取得
        return view('admin.list', ['stocks' => $stocks]);
    }

    public function search(Request $request)
    {
        $keyword = $request->input('search');

        if(!empty($keyword)) {
            $stocks = Stock::where('name', 'like', "%{$keyword}%")->simplePaginate(8);
            $count = $stocks->count();
            $param = ['keyword' => $keyword, 'stocks' => $stocks, 'count' => $count];
            return view('admin.search', $param);
        } elseif(empty($keyword)) {
            $count = 0;
            $keyword = '';
            $err = 'キーワードが入力されていません。';
            $param = ['keyword' => $keyword, 'err' => $err, 'count' => $count];
            return view('admin.search', $param);
        }
    }

    public function show(Request $request,$id)
    {
        $stock = Stock::find($id);
        return view('admin.show', ['stock' => $stock]);
    }

    public function delCheck(Request $request,$id)
    {
        $stock = Stock::find($id); //idによるレコード検索
        return view('admin.delCheck', ['stock' => $stock]);
    }

    public function delDone(Request $request,$id)
    {
        Stock::find($id)->delete();
        return redirect('admin/list');
    }

}
