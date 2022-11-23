<?php

namespace App\Http\Requests\Locker;

use Illuminate\Foundation\Http\FormRequest;

class CreateLockerRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'number' => 'required|integer|gte:1',
            'is_active' => 'required|boolean',
            'is_woman' => 'required|boolean',
        ];
    }
}
