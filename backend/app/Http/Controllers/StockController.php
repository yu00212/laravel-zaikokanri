<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\ValidateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StockController extends Controller
{
    public function __construct() { //  __construct クラスを追加
        $this->middleware('auth'); // ログイン者のみ下記メソッドを実行可能に
    }

    public function index(Request $request)
    {
        $user_id = Auth::id(); //ログインユーザーのID取得
        $stocks = Stock::with('user')->where('user_id', '=', $user_id)->simplePaginate(8);
        return view('stock.list', ['stocks' => $stocks]);
    }

    public function search(Request $request)
    {
        $keyword = $request->input('search');
        $user_id = Auth::id();

        if(!empty($keyword)) {
            $stock = Stock::with('user')->where('user_id', '=', $user_id); //ログインユーザーと紐ついた在庫を取得
            $stocks = $stock->where('name', 'like', "%{$keyword}%")->simplePaginate(8); //検索ワードに該当する在庫を取得
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

    public function add(Request $request)
    {
        return view('stock.add');
    }

    public function addCheck(ValidateRequest $request)
    {
        $shop = $request->shop;
        $purchase_date = $request->purchase_date;
        $deadline = $request->deadline;
        $name = $request->name;
        $price = $request->price;
        $number = $request->number;
        $image = $request->file('image');

        $stock = [
            'shop' => $shop,
            'purchase_date' => $purchase_date,
            'deadline' => $deadline,
            'name' => $name,
            'price' => $price,
            'number' => $number,
            'image' => $image
        ];

        return view('stock.addCheck', ['stock' => $stock]);
    }

    public function addDone(Request $request)
    {
        $action = $request->get('action','back','register');
        $input = $request->except('action');
        //$image = $request->file('image');

        if($action === 'back'){
            return redirect('/list/add')->withInput($input);
        } elseif($action === 'register') {
            $stock = new Stock; // Stockインスタンス作成(保存作業)
            $form = $request->all(); //保管する値を用意
            unset($form['_token']); //フォームに追加される非表示フィールド(テーブルにない)「_token」のみ削除しておく

            // 画像ファイルの保存場所指定
            if($request->file("image") !== null){
                //$filename=request()->$image->getClientOriginalName();
                //$inputs['image']=request('image')->storeAs('public/images', $filename);
                //$filename   = $request->$image->store("public/images");
                $filename = $request->file('image')->store("public/images/");
                $stock->image = basename($filename);
            }

            $stock->fill($form)->save(); //インスタンスに値を設定して保存
            return redirect('/list');
        }
    }

    public function show(Request $request,$id)
    {
        $stock = Stock::find($id);
        return view('stock.show', ['stock' => $stock]);
    }

    public function edit(Request $request,$id)
    {
        $stock = Stock::find($id); //idによるレコード検索
        return view('stock.edit', ['stock' => $stock]);
    }

    public function editCheck(ValidateRequest $request,$id)
    {
        $id = $request->id;
        $shop = $request->shop;
        $purchase_date = $request->purchase_date;
        $deadline = $request->deadline;
        $name = $request->name;
        $price = $request->price;
        $number = $request->number;

        $stock = [
            'id' => $id,
            'shop' => $shop,
            'purchase_date' => $purchase_date,
            'deadline' => $deadline,
            'name' => $name,
            'price' => $price,
            'number' => $number
        ];

        return view('stock.editCheck', ['stock' => $stock]);
    }

    public function editDone(Request $request,$id)
    {
        $stock = Stock::find($id); //idによるレコード検索
        $form = $request->all(); //保管する値を用意
        unset($form['_token']); //フォームに追加される非表示フィールド(テーブルにない)「_token」のみ削除しておく
        $stock->fill($form)->save(); //インスタンスに値を設定して保存
        return redirect('/list');
    }

    public function editReturn(ValidateRequest $request,$id)
    {
        $id = $request->id;
        $shop = $request->shop;
        $purchase_date = $request->purchase_date;
        $deadline = $request->deadline;
        $name = $request->name;
        $price = $request->price;
        $number = $request->number;

        $stock = [
            'id' => $id,
            'shop' => $shop,
            'purchase_date' => $purchase_date,
            'deadline' => $deadline,
            'name' => $name,
            'price' => $price,
            'number' => $number
        ];

        return view('stock.edit', ['stock' => $stock]);
    }

    public function delCheck(Request $request,$id)
    {
        $stock = Stock::find($id); //idによるレコード検索
        return view('stock.delCheck', ['stock' => $stock]);
    }

    public function delDone(Request $request,$id)
    {
        Stock::find($id)->delete();
        return redirect('/list');
    }

}
