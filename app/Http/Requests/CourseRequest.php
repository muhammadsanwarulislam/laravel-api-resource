<?php

namespace App\Http\Requests;

use App\Helpers\APIHelpers;
use App\Models\Api\Course;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CourseRequest extends FormRequest
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
        $rules = Course::VALIDATION_RULES;

        if ($this->getMethod() == 'POST') {
            $rules += [
                'course_code' => 'required|unique:courses',
            ];
        } else {
            $rules += [
                'course_code' => 'required|' . Rule::unique('courses', 'course_code')->ignore(request()->route('course'))
            ];
        }

        return $rules;
    }


    public function messages()
    {
        return [
            'course_name.required' => 'The Course Name Field Is Required',
            'course_code.required' => 'The Course Code Field Is required.',
            'course_code.unique' => 'The Course Code Has Already Been Taken.'
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
