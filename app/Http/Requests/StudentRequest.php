<?php

namespace App\Http\Requests;

use App\Helpers\APIHelpers;
use App\Models\Api\Student;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class StudentRequest extends FormRequest
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

        $rules = Student::VALIDATION_RULES;

        if ($this->getMethod() == 'POST') {
            $rules += [
                'email' => 'required|email|unique:students',
            ];
        } else {
            $rules += [
                'email' => 'required|email|' . Rule::unique('students', 'email')->ignore(request()->route('student'))
            ];
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'The Name Field Is Required',
            'email.required' => 'The Email Field Is required.',
            'email.unique' => 'The Email Has Already Been Taken.'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $code = Response::HTTP_UNPROCESSABLE_ENTITY;

        $message = "Validation Failed!";

        $response = APIHelpers::createAPIResponse(true, $code, $message, $validator->errors());

        throw new HttpResponseException(new JsonResponse($response, $code));
    }
}
