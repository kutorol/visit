<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class CreatePurchaseRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => 'required|string|gte:1|exists:users,id',
            'product_id' => 'required|gte:1|exists:products,id',
        ];
    }
}
