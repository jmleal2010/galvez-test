<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ChecklistRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:5',
            'description' => 'nullable|string',
            'tasks' => 'required|array|min:1',
            'date' => 'required|date_format:Y-m-d'
        ];
    }

    /**
     * @return array{name.required: string, name.min: string, tasks.required: string, tasks.array: string, date.format: string}
     */
    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es requerido.',
            'name.min' => 'El nombre no cumple con el formato .',
            'tasks.required' => 'Las tareas son obligatorias, debe adjuntar al menos una.',
            'tasks.array' => 'El formato de las tareas no es correcto',
            'date.format' => 'El formato de la fecha  no es correcto',
        ];
    }
}
