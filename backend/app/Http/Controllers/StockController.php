<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\ValidateRequest;
use Illuminate\Support\Facades\Auth;

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
            $stock = Stock::where('name', 'like', "%{$keyword}%")->get();
            //$stocks = Stock::with('user')->where('user_id', '=', $user_id)->simplePaginate(8);
            $stocks = $stock->with('user')->where('user_id', '=', $user_id)->simplePaginate(8);
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

        $stock = [
            'shop' => $shop,
            'purchase_date' => $purchase_date,
            'deadline' => $deadline,
            'name' => $name,
            'price' => $price,
            'number' => $number
        ];

        return view('stock.addCheck', ['stock' => $stock]);
    }

    public function addDone(Request $request)
    {
        $action = $request->get('action','back','register');
        $input = $request->except('action');

        if($action === 'back'){
            return redirect('/list/add')->withInput($input);
        } elseif($action === 'register') {
            $stock = new Stock; // Stockインスタンス作成(保存作業)
            $form = $request->all(); //保管する値を用意
            unset($form['_token']); //フォームに追加される非表示フィールド(テーブルにない)「_token」のみ削除しておく
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
        //編集内容入力画面 idから元の登録データは入力欄に表示しておく
        $stock = Stock::find($id); //idによるレコード検索
        return view('stock.edit', ['stock' => $stock]);
    }

    public function editCheck(ValidateRequest $request,$id)
    {
        //入力内容確認
        //入力内容を変数に入れてeditCheck.blade.phpで表示
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
        //編集が完了したらlist.blade.php（在庫一覧）にリダイレクト
        //戻るの場合、入力内容を保持したままedit.bladeにリダイレクト
        $id = $request->id;
        $action = $request->get('action','back','edit');
        $input = $request->except('action');

        if($action === 'back'){
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

            //return redirect('list/edit/{$id}')->withInput($input);
            //return redirect(route('edit', [
                //'id' => $id,
                //'shop' => $shop,
                //'purchase_date' => $purchase_date,
                //'deadline' => $deadline,
                //'name' => $name,
                //'price' => $price,
                //'number' => $number
            //]));

        } elseif($action === 'edit') {
            $stock = Stock::find($id); //idによるレコード検索
            $form = $request->all(); //保管する値を用意
            unset($form['_token']); //フォームに追加される非表示フィールド(テーブルにない)「_token」のみ削除しておく
            $stock->fill($form)->save(); //インスタンスに値を設定して保存
            return redirect('/list');
        }
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
