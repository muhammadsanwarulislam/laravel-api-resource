<?php

namespace App\Http\Requests;

use App\Helpers\APIHelpers;
use App\Models\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class SignUpRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        $rules = User::REGISTRATION_VALIDATION_RULES;

        if ($this->getMethod() == 'POST') {
            $rules += [
                'email' => [
                    'required',
                    'string',
                    'email',
                    'unique:users'
                ],
                'password' => [
                    'required',
                    'string',
                    'confirmed',
                    'min:6',
                    'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%]).*$/'
                ]
            ];
        } else {
            $rules += [
                'email' => [
                    'required',
                    'string',
                    'email',
                    Rule::unique('users', 'email')->ignore(request()->route('users'))
                ],
                'password' => [
                    'sometimes',
                    'string',
                    'min:6',
                    'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%]).*$/'
                ]
            ];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name field must be string.',
            'name.between' => 'The name field must be between 2-100 characters.',
            'email.required' => 'The email field is required.',
            'email.email' => 'Invalid email format.',
            'email.unique' => 'The email has already been taken.',
            'password.required' => 'The password filed is required.',
            'password.confirmed' => 'Password does not match with confirm password.',
            'password.min' => 'The password length must be at least 6 characters',
            'password.regex' => 'Invalid password format.',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $code = Response::HTTP_UNPROCESSABLE_ENTITY;

        $message = "Registration Failed!";

        $response = APIHelpers::createAPIResponse(true, $code, $message, $validator->errors());

        throw new HttpResponseException(new JsonResponse($response, $code));
    }
}
