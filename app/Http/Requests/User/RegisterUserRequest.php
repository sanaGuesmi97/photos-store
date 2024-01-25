<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
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
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|confirmed',
            'image' => 'sometimes|mimes:jpeg,png,gif,svg|max:2048',
            'role' => 'in:admin,client,artist'
        ];
    }
    public function messages()
    {
        return [
            'firstName.required' => 'Le champ Prénom est obligatoire.',
            'lastName.required' => 'Le champ Nom est obligatoire.',
            'email.email' => 'Veuillez entrer une adresse email valide.',
            'email.unique' => 'Cette adresse email est déjà utilisée.',
            'password.required' => 'Le champ mot de passe est obligatoire.',
            'password.string' => 'Le mot de passe doit être une chaîne de caractères.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
            'role.in' => 'Rôle invalide. Veuillez choisir soit "admin" soit "client"ou "artist".',
        ];
    }
}
