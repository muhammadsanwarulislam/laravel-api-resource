<?php

namespace App\Http\Controllers\Api;

use App\Helpers\APIHelpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\StudentRequest;
use App\Http\Resources\StudentResource;
use App\Http\Resources\UserResource;
use App\Models\Api\Student;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return StudentResource
     */
    public function index()
    {
        try {
            $students = Student::all();

            $code = Response::HTTP_FOUND;

            $message = $students->count() . " Students Found!";

            $response = APIHelpers::createAPIResponse(false, $code, $message, StudentResource::collection($students));

        } catch (QueryException $exception) {

            $code = $exception->getCode();

            $message = $exception->getMessage();

            $response = APIHelpers::createAPIResponse(true, $code, $message, null);
        }

        return new JsonResponse($response, $code == Response::HTTP_FOUND ? Response::HTTP_FOUND : Response::HTTP_NO_CONTENT);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param StudentRequest $request
     * @return StudentResource
     */
    public function store(StudentRequest $request)
    {
        $student = null;

        try {
            $student = Student::create([
                'name' => $request->name,
                'email' => $request->email
            ]);

            $user = User::create([
                'name' => $student->name,
                'email' => $student->email,
                'password' => "@#gmail.com12",
                'password_confirmation' => "@#gmail.com12",
            ]);

            $data = [
                'student' => new StudentResource($student),
                'user' => new UserResource($user),
            ];


            $code = Response::HTTP_CREATED;

            $message = "Student Created Successfully";

            $response = APIHelpers::createAPIResponse(false, $code, $message, $data);

        } catch (QueryException $exception) {
            $message = $exception->getMessage();
            $code = $exception->getCode();
            $response = APIHelpers::createAPIResponse(true, $code, $message, null);

        }

        return new JsonResponse($response, $student ? Response::HTTP_CREATED : Response::HTTP_INTERNAL_SERVER_ERROR);


    }


    /**
     * Display the specified resource.
     *
     * @param Student $student
     * @return JsonResponse
     */
    public function show(Student $student)
    {
        try {
            $code = Response::HTTP_FOUND;
            $message = "Student Found!";

            $response = APIHelpers::createAPIResponse(false, $code, $message, new StudentResource($student));
        } catch (QueryException $exception) {
            $code = $exception->getCode();
            $message = $exception->getMessage();
            $response = APIHelpers::createAPIResponse(true, $code, $message, null);
        }

        return new JsonResponse($response, $student ? Response::HTTP_FOUND : Response::HTTP_NO_CONTENT);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param StudentRequest $request
     * @param Student $student
     * @return JsonResponse
     */
    public function update(StudentRequest $request, Student $student)
    {
        $isUpdated = false;
        try {
            $isUpdated = $student->update([
                'name' => $request->name ? $request->name : $student->name,
                'email' => $request->email ? $request->email : $student->email,
            ]);

            $code = Response::HTTP_CREATED;
            $message = "Student Updated Successfully!";
            $response = APIHelpers::createAPIResponse(false, $code, $message, new StudentResource($student));
        } catch (QueryException $exception) {
            $code = $exception->getCode();
            $message = $exception->getMessage();
            $response = APIHelpers::createAPIResponse(true, $code, $message, null);
        }

        return new JsonResponse($response, $isUpdated ? Response::HTTP_CREATED : Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Student $student
     * @return JsonResponse
     */
    public function destroy(Student $student)
    {
        $isDeleted = false;

        try {
            $isDeleted = $student->delete();
            $code = Response::HTTP_OK;
            $message = "Student Deleted Successfully";
            $response = APIHelpers::createAPIResponse(false, $code, $message, null);
        } catch (QueryException $exception) {
            $code = $exception->getCode();
            $message = $exception->getMessage();
            $response = APIHelpers::createAPIResponse(true, $code, $message, null);
        }

        return new JsonResponse($response, $isDeleted ? Response::HTTP_OK : Response::HTTP_INTERNAL_SERVER_ERROR);

    }
}
