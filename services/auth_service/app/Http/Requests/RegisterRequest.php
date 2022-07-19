<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class RegisterRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'instance.name' => 'required|max:255',
            'instance.instance_type_id' => 'required|integer|exists:instance_types,id',
            'user.name' => 'required|max:255',
            'user.email' => 'required|email:rfc,dns,spoof|unique:users,email',
            'user.password' => 'required|confirmed'
        ];
    }
}
