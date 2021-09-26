<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;
use App\Http\Requests\ValidateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GuestController extends Controller
{
    public function __construct()
    { //  __construct クラスを追加
        $this->middleware('auth'); // ログイン者のみ下記メソッドを実行可能に
    }

    public function index(Request $request)
    {
        $user_id = Auth::id(); //ログインユーザーのID取得
        $stocks = Stock::with('user')->where('user_id', '=', $user_id)->simplePaginate(6);
        $count = 0;
        $keyword = $request->input('search');
        return view('stock.list', ['stocks' => $stocks, 'keyword' => $keyword, 'count' => $count]);
    }

    public function search(Request $request)
    {
        $keyword = $request->input('search');
        $user_id = Auth::id();

        if (empty($keyword)) {
            $count = 0;
            $keyword = '';
            $err = 'キーワードが入力されていません。';
            $param = ['keyword' => $keyword, 'err' => $err, 'count' => $count];
            return view('stock.list', $param);
        }

        $stock = Stock::with('user')->where('user_id', '=', $user_id); //ログインユーザーと紐ついた在庫を取得
        $stocks = $stock->where('name', 'like', "%{$keyword}%")->simplePaginate(6); //検索ワードに該当する在庫を取得
        $count = $stocks->count();
        $param = ['keyword' => $keyword, 'stocks' => $stocks, 'count' => $count];
        return view('stock.list', $param);
    }

    public function add()
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
        $image = "";
        if ($request->file("image") !== null) {
            $imagepath = $request->file('image')->store("public/tmp/");
            $image = basename($imagepath);
        }

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
        $action = $request->get('action', 'back', 'register');
        $input = $request->except('action');

        if ($action === 'back') {
            return redirect('/guest/list/add')->withInput($input);
        } elseif ($action === 'register') {
            $stock = new Stock; //Stockインスタンス作成(保存作業)
            $form = $request->all(); //保管する値を用意
            unset($form['_token']); //フォームに追加される非表示フィールド(テーブルにない)「_token」のみ削除しておく

            $stock->fill($form); //インスタンスに値を設定

            //画像ファイルの保存場所移動
            $stock->image = "dummy.jpg";
            if ($request->image !== null) {
                Storage::move("public/tmp/" . $request->image, "public/images/" . $request->image);
                $stock->image = $request->image;
            }

            $stock->save(); //インスタンスを保存
            return redirect('/guest/list');
        }
    }

    public function show($id)
    {
        $stock = Stock::find($id);
        return view('stock.show', ['stock' => $stock]);
    }

    public function edit($id)
    {
        $stock = Stock::find($id); //idによるレコード検索
        return view('stock.edit', ['stock' => $stock]);
    }

    public function editCheck(ValidateRequest $request, $id)
    {
        $id = $request->id;
        $shop = $request->shop;
        $purchase_date = $request->purchase_date;
        $deadline = $request->deadline;
        $name = $request->name;
        $price = $request->price;
        $number = $request->number;
        $image = "";
        $returnImage = "";

        if ($request->file("image") !== null) {
            $imagepath = $request->file('image')->store("public/tmp/");
            $image = basename($imagepath);
        } elseif ($request->file("image") == null) {
            $stocks = Stock::find($id); //idによるレコード検索
            $returnImage = $stocks['image'];
        }

        $stock = [
            'id' => $id,
            'shop' => $shop,
            'purchase_date' => $purchase_date,
            'deadline' => $deadline,
            'name' => $name,
            'price' => $price,
            'number' => $number,
            'image' => $image
        ];

        return view('stock.editCheck', ['stock' => $stock, 'returnImage' => $returnImage]);
    }

    public function editDone(Request $request, $id)
    {
        $action = $request->get('action', 'back', 'edit');
        $input = $request->except('action');

        if ($action === 'back') {
            return redirect('/guest/list/edit/' . $id)->withInput($input);
        } elseif ($action === 'edit') {
            $stock = Stock::find($id); //idによるレコード検索
            $form = $request->all(); //保管する値を用意
            unset($form['_token']); //フォームに追加される非表示フィールド(テーブルにない)「_token」のみ削除しておく
            if ($request->file("image") == null) {
                //$stock = Stock::find($id); //idによるレコード検索
                unset($form['image']);
            }
            $stock->fill($form); //インスタンスに値を設定

            //画像ファイルの保存場所移動
            if ($request->image !== null) {
                Storage::move("public/tmp/" . $request->image, "public/images/" . $request->image);
                $stock->image = $request->image;
            }

            $stock->save(); //インスタンスを保存
            return redirect('/guest/list');
        }
    }

    public function delCheck($id)
    {
        $stock = Stock::find($id); //idによるレコード検索
        return view('stock.delCheck', ['stock' => $stock]);
    }

    public function delDone($id)
    {
        Stock::find($id)->delete();
        return redirect('/guest/list');
    }
}