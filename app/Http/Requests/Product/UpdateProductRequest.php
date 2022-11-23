<?php

namespace App\Http\Requests\Product;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => 'required|integer|gte:1',
            'name' => 'nullable|string|min:1|max:255',
            'type' => 'nullable|in:' . join(",", Product::getTypes()),
            'days' => 'nullable|integer|gte:1',
            'price' => 'nullable|numeric|gt:1',
        ];
    }
}
