<?php

namespace App\Repository\Stock;

use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EloquentStockRepository implements StockRepository
{

    public function getStocks()
    {
        $user_id = Auth::id(); //ログインユーザーのID取得
        return Stock::with('user')->where('user_id', '=', $user_id)->Paginate(6);
    }

    public function getStocksById($id)
    {
        return Stock::select('id', 'name', 'description', 'status')->whereId($id)->first(); //IDで検索して最初の一件のみ取得
    }

    public function createStock(Request $request)
    {
        $Stock = new Stock; //新規Stockを保存→以下の各カラムデータを保存
        $Stock->name = $request->name;
        $Stock->description = $request->description;
        $Stock->save();
        return $Stock;
    }

    public function setAsFinish($id)
    {
        $Stock = Stock::whereId($id)->first(); //IDで検索して最初のタスクデータ全カラムを一件のみ取得
        if ($Stock != null) {
            $Stock->status = true; //タスクがあればstatusカラムにtureを入れて保存
            $Stock->save();
            return $Stock;
        }
        return null; //タスクがなければnullを返す
    }

    public function updateStock(Request $request, $id)
    {
        $Stock = Stock::whereId($id)->first(); //IDで検索して最初のタスクデータ全カラムを一件のみ取得
        if ($Stock != null) {
            $Stock->update([
                'name' => $request->name, //タスクデータがあった場合各カラムをアップデート保存
                'description' => $request->description,
            ]);
            return $Stock;
        }
        return null;
    }

    public function getStockWithComments($id)
    {
        return Stock::select('id', 'name', 'description', 'status')
            ->whereId($id)
            ->with('comments')->first(); //IDでタスクデータの各カラムを検索→コメントデータと一緒に初めの一件のみ取得
    }
}
