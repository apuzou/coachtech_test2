<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
{
    /**
     * 認可の判定
     */
    public function authorize()
    {
        return true;
    }

    /**
     * バリデーションルール
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|between:0,10000',
            'seasons' => 'required|array',
            'seasons.*' => 'exists:seasons,id',
            'description' => 'required|string|max:120',
            'image' => 'nullable|file|mimes:png,jpeg,jpg|max:2048',
        ];
    }

    /**
     * カスタムエラーメッセージ
     */
    public function messages()
    {
        return [
            'name.required' => '商品名を入力してください',
            'price.required' => '値段を入力してください',
            'price.numeric' => '数値で入力してください',
            'price.between' => '0-10000円以内で入力してください',
            'seasons.required' => '季節を選択してください',
            'description.required' => '商品説明を入力してください',
            'description.max' => '120文字以内で入力してください',
            'image.mimes' => '「.png」または「.jpeg」形式でアップロードしてください',
        ];
    }

    /**
     * カスタムバリデーション
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // 商品画像の必須チェック
            $product = $this->route('product');
            if (!$this->hasFile('image') && !$product->image) {
                $validator->errors()->add('image', '商品画像を登録してください');
            }
        });
    }
}