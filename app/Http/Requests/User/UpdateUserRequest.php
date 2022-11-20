<?php

declare(strict_types=1);

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function rules()
    {
        return [
            'id' => 'required|integer|min:1',
            'name' => 'nullable|string|min:1|max:255',
            'email' => 'nullable|email|unique:users',
            'role' => 'nullable|in:'.implode(',', User::roles()),
            'password' => 'nullable',
            'password_confirmation' => 'required_with:password|same:password',
        ];
    }
}
