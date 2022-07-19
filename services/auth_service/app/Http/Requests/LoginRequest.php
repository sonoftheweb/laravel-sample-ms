<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use JetBrains\PhpStorm\ArrayShape;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Auth::guest();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    #[ArrayShape(['email' => "string", 'password' => "string", 'remember_me' => "boolean"])]
    public function rules(): array
    {
        return [
            'email' => 'required|email|exists:users,email',
	        'password' => 'required|min:3|max:10',
	        'remember_me' => 'boolean'
        ];
    }
}
