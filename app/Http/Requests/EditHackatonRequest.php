<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

// class EditHackatonRequest extends FormRequest
// {

//     /**
//          * Determine if the user is authorized to make this request.
//          */
//         public function authorize(): bool
//         {
//             return true;
//         }

//         /**
//          * Get the validation rules that apply to the request.
//          *
//          * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
//          */
//         public function rules(): array
//         {
//             return [
//                 'name' => 'required',
//                 'structure_organisateur' => 'required',
//                 'description' => 'required',
//                 'date_debut' => 'required',
//                 'date_fin' => 'required',
//                 'lieu' => 'required',
//                 'logo_url'=>'nullable',

//             ];
//         }

//         public function failedValidation(Validator $validator)
//         {
//             throw new HttpResponseException(response()->json([
//                 'success' => false,
//                 'status_code' => 422,
//                 'errors' => true,
//                 'errorList' => $validator->errors(),
//             ]));
//         }
//         public function messages()
//         {
//             return [

//                 'name.required' => 'Le nom est obligatoire',
//                 'structure_organisateur.required' => 'La structure est obligatoire',
//                 'description.required' => 'La description est obligatoire',
//                 'date_debut.required' => 'La date de début est obligatoire',
//                 'date_fin.required' => 'La date de fin est obligatoire',
//                 'lieu.required' => 'Le lieu est obligatoire',
//             ];
//         }
//     }
class EditHackatonRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required',
            'structure_organisateur' => 'required',
            'description' => 'required',
            'date_debut' => 'required',
            'date_fin' => 'required',
            'lieu' => 'required',
            'logo_url' => 'nullable',
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
            'name.required' => 'Le nom est obligatoire',
            'structure_organisateur.required' => 'La structure est obligatoire',
            'description.required' => 'La description est obligatoire',
            'date_debut.required' => 'La date de début est obligatoire',
            'date_fin.required' => 'La date de fin est obligatoire',
            'lieu.required' => 'Le lieu est obligatoire',
        ];
    }
}


