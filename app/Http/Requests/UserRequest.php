<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserRequest extends FormRequest
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
            'name' => 'required|string|max:50|regex:([a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+)',
            'last_name' => 'required|string|max:50|regex:([a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+)',
            'email' => 'required|string|email|max:255|unique:users,email',
            'id_number' => 'required|numeric|min:1999999999|max:99999999999|unique:users,id_number',
            'password' => ['required',Password::defaults()->min(8)->letters()->mixedCase()->numbers()->symbols()->uncompromised()],
            'password_confirmation' => 'required|same:password' 
        ];
    }
}
