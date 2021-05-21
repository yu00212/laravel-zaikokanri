<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'shop' => 'required|string|min:1|max:50',
            'purchase_date' => 'required|date_format:Y-m-d',
            'deadline' => 'required|date_format:Y-m-d',
            'name' => 'required|string|min:1|max:50',
            'price' => 'required|integer|digits_between:1,4',
            'number' => 'required|integer|digits_between:1,2'
        ];
    }

    public function messages()
    {
        return [
            'shop.required' => '店名を1~50字以内で入力してください。' ,
            'shop.min:1' => '店名を1~50字以内で入力してください。' ,
            'shop.max:50' => '店名を1~50字以内で入力してください。' ,
            'purchase_date.required' => '購入日をカレンダーから選択してください。' ,
            'purchase_date.date_format:Y-m-d' => '購入日をカレンダーから選択してください。' ,
            'deadline.required' => '期限をカレンダーから選択してください。' ,
            'deadline.date_format:Y-m-d' => '消費・賞味期限をカレンダーから選択してください。' ,
            'name.required' => '名前を1~50字以内で入力してください。' ,
            'name.min:1' => '名前を1~50字以内で入力してください。' ,
            'name.max:50' => '名前を1~50字以内で入力してください。' ,
            'price.required' => '値段を1~4桁の数字で入力してください。' ,
            'price.integer' => '値段を1~4桁の数字で入力してください。' ,
            'price.digits_between' => '値段を1~4桁の数字で入力してください。' ,
            'number.required' => '数量を1~2桁の数字で入力してください。' ,
            'number.integer' => '数量を1~2桁の数字で入力してください。' ,
            'number.digits_between' => '数量を1~2桁の数字で入力してください。' ,
        ];
    }
}
