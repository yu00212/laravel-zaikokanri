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
    {
        $this->middleware('auth'); // ログイン者のみ下記メソッドを実行可能に
    }

    //在庫一覧画面
    public function index(Request $request)
    {
        $user_id = Auth::id(); //ログインユーザーのID取得
        $stocks = Stock::with('user')->where('user_id', '=', $user_id)->simplePaginate(6);
        $count = 0;
        $keyword = $request->input('search');
        return view('stock.list', ['stocks' => $stocks, 'keyword' => $keyword, 'count' => $count]);
    }

    //在庫検索
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

    //在庫追加入力画面
    public function add()
    {
        return view('stock.add');
    }

    //在庫追加確認画面から入力画面に戻る場合に入力した値を保ったまま戻る
    public function addReturn(Request $request)
    {
        $input = $request->except('action');
        return redirect('/guest/list/add')->withInput($input);
    }

    //在庫追加確認画面
    public function addCheck(ValidateRequest $request)
    {
        $shop = $request->shop;
        $purchase_date = $request->purchase_date;
        $deadline = $request->deadline;
        $name = $request->name;
        $price = $request->price;
        $number = $request->number;
        $image = "";

        //画像ファイルが選択されている場合、public/tmp/に一旦仮保存する
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

    //在庫追加DB反映
    public function addDone(Request $request)
    {
        $stock = new Stock; //Stockインスタンス作成(保存作業)
        $form = $request->all(); //保管する値を用意
        unset($form['_token']); //フォームに追加される非表示フィールド(テーブルにない)「_token」のみ削除しておく

        $stock->fill($form); //インスタンスに値を設定

        //画像ファイルの保存場所移動
        $stock->image = "dummy.jpg";
        if ($request->image !== null) {
            $image = Storage::get('public/tmp/' . $request->image);
            $path = Storage::disk('s3')->put($request->image, $image, 'public');
            $stock->image = $request->image;
        }

        $stock->save(); //インスタンスを保存
        return redirect('/guest/list');
    }

    //在庫詳細画面
    public function show($id)
    {
        $stock = Stock::find($id);
        return view('stock.show', ['stock' => $stock]);
    }

    //在庫編集入力画面
    public function edit($id)
    {
        $stock = Stock::find($id); //idによるレコード検索
        return view('stock.edit', ['stock' => $stock]);
    }

    //在庫編集確認画面
    public function editCheck(ValidateRequest $request, $id)
    {
        //編集画面からの入力情報をrequestで取得
        $id = $request->id;
        $shop = $request->shop;
        $purchase_date = $request->purchase_date;
        $deadline = $request->deadline;
        $name = $request->name;
        $price = $request->price;
        $number = $request->number;

        $image = "";
        $returnImage = "";

        //新規画像ファイルが送信されてたらpublic/tmp/に仮保存
        //新規画像ファイルが無ければidから登録済みの既存画像ファイルを取得
        if ($request->file("image") !== null) {
            $imagepath = $request->file('image')->store("public/tmp/");
            $image = basename($imagepath); //basename（）でファイル名のみ抜き出し
        } elseif ($request->file("image") == null) {
            $returnImage = Stock::find($id); //idによるレコード検索
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

    //在庫編集DB反映
    public function editDone(Request $request, $id)
    {
        $stock = Stock::find($id); //idによるレコード検索
        $form = $request->all(); //保管する値を用意
        unset($form['_token']); //フォームに追加される非表示フィールド(テーブルにない)「_token」のみ削除しておく
        if ($request->image == null) {
            unset($form['image']); //新規画像が無ければimageカラムを外す
        }
        $stock->fill($form); //インスタンスに値を設定

        //画像ファイルの保存場所移動
        if ($request->image !== null) {
            $image = Storage::get('public/tmp/' . $request->image);
            $path = Storage::disk('s3')->put($request->image, $image, 'public');
            $stock->image = $request->image;
        }

        $stock->save(); //インスタンスを保存
        return redirect('/guest/list');
    }

    //在庫削除確認画面
    public function delCheck($id)
    {
        $stock = Stock::find($id); //idによるレコード検索
        return view('stock.delCheck', ['stock' => $stock]);
    }

    //在庫削除DB反映
    public function delDone($id)
    {
        Stock::find($id)->delete();
        return redirect('/guest/list');
    }
}
