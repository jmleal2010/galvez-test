<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class TaskRequest extends FormRequest
{
    //Determina si es el usuario autenticado tiene permitido realizar esta petición
    public function authorize(): bool
    {
        return Auth::hasUser() && Auth::user();
    }

    //Reglas de validación
    public function rules()
    {
        return [
            'name' => 'required|string|min:5',
            'description' => 'nullable|string',
        ];
    }
}
