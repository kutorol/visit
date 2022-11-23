<?php

namespace App\Http\Requests\Product;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:1|max:255',
            'type' => 'required|in:' . join(",", Product::getTypes()),
            'days' => 'required|integer|gte:1',
            'price' => 'required|numeric|gt:1',
        ];
    }
}
