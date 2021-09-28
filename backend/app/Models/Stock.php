<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
    protected $fillable = ['shop', 'purchase_date', 'deadline', 'name', 'price', 'number', 'image'];

    //1対nのリレーション追加
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function boot()
    {
        parent::boot();

        // 保存時user_idをログインユーザーに設定
        self::saving(function ($stock) {
            $stock->user_id = \Auth::id();
        });
    }
}
