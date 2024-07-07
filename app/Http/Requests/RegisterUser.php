<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterUser extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'status' => 'required',
            'role_id' => 'required|exists:roles,id', // Validation for role_id
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',


        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'status_code' => 422,
            'errors' => true,
            'errorList' => $validator->errors(),
        ]));
    }

    public function messages()
    {
        return [
            'firstname.required' => 'Le prénom est obligatoire',
            'lastname.required' => 'Le nom est obligatoire',
            'email.required' => 'L\'email est obligatoire',
            'email.email' => 'L\'email doit être valide',
            'email.unique' => 'L\'email est déjà utilisé',
            'password.required' => 'Le mot de passe est obligatoire',
            'password.min' => 'Le mot de passe doit contenir au moins 6 caractères',
            'status.required' => 'Le statut est obligatoire',
            'role_id.required' => 'Le rôle est obligatoire',
            'role_id.exists' => 'Le rôle sélectionné est invalide',
            'photo.image' => 'Le fichier doit être une image',
            'photo.mimes' => 'L\'image doit être de type jpeg, png, jpg, gif, svg',
            'photo.max' => 'L\'image ne doit pas dépasser 2MB',
        ];
    }
}
