<?php

namespace App\Repository\Stock;

use App\Models\Stock;
use Illuminate\Http\Request;

interface StockRepository
{
    public function createStock(Request $request);
    public function getStocks();
    public function getStocksById($id);
    public function updateStock(Request $request, $id);
    public function setAsFinish($id);
}
