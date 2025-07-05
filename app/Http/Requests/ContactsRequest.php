<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContactsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $contactId = $this->route('contact')?->id;
        return [
            'name' => ['required', 'string', 'min:3', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:150', Rule::unique('contacts', 'email')->where('deleted_at', null)->ignore($contactId)],
            'phone' => ['required', 'string', 'regex:/^(?:\D*\d){10,20}\D*$/'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome é obrigatório.',
            'name.min' => 'O nome deve ter pelo menos 3 caracteres.',
            'name.max' => 'O nome deve ter no máximo 100 caracteres.',
            'email.required' => 'O email é obrigatório.',
            'email.email' => 'O email deve ser um email válido.',
            'email.max' => 'O email deve ter no máximo 150 caracteres.',
            'email.unique' => 'O email já existe.',
            'phone.required' => 'O telefone é obrigatório.',
            'phone.regex' => 'O telefone deve ter pelo menos 10 caracteres.',
            'notes.max' => 'As notas não podem ter mais de 1000 caracteres.',
        ];
    }
}
