<?php

namespace App\Http\Requests\Locker;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLockerRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => 'required|integer|gte:1',
            'number' => 'nullable|integer|gte:1',
            'is_active' => 'nullable|boolean',
            'is_woman' => 'nullable|boolean',
            'released_at' => 'nullable|date_format:Y-m-d H:i:s'
        ];
    }
}
