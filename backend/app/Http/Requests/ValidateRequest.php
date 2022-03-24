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
            'shop' => 'max:50',
            'purchase_date' => 'date_format:Y-m-d',
            'deadline' => 'date_format:Y-m-d',
            'name' => 'required|max:50',
            'price' => 'integer|digits_between:1,4',
            'number' => 'integer|digits_between:1,2',
            'image' => 'file|image|mimes:jpg,png'
        ];
    }

    public function messages()
    {
        return [
            'shop.max:50' => '店名を1~50字以内で入力してください。',
            'purchase_date.date_format:Y-m-d' => '購入日をカレンダーから選択してください。',
            'deadline.date_format:Y-m-d' => '期限をカレンダーから選択してください。',
            'name.max:50' => '名前を1~50字以内で入力してください。',
            'price.integer' => '値段を1~4桁の数字で入力してください。',
            'price.digits_between' => '値段を1~4桁の数字で入力してください。',
            'number.integer' => '数量を1~2桁の数字で入力してください。',
            'number.digits_between' => '数量を1~2桁の数字で入力してください。',
            'number.file' => 'アップロードされたファイルを選択してください。',
            'number.image' => '画像ファイルを選択してください。',
            'number.mimes:jpg,png' => '画像ファイルを選択してください。。',
        ];
    }
}
