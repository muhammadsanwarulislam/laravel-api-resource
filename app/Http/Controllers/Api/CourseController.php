<?php

namespace App\Http\Controllers\Api;

use App\Helpers\APIHelpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use App\Http\Resources\CourseResource;
use App\Models\Api\Course;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        try {
            $courses = Course::all();
            $code = Response::HTTP_FOUND;
            $message = $courses->count() . " Courses Found!";
            $response = APIHelpers::createAPIResponse(false, $code, $message, CourseResource::collection($courses));
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
     * @param CourseRequest $request
     * @return JsonResponse
     */
    public function store(CourseRequest $request)
    {
        $course = null;
        try {
            $course = Course::create([
                'course_name' => $request->course_name,
                'course_code' => $request->course_code
            ]);

            $code = Response::HTTP_CREATED;

            $message = "Course Created Succcessfully!";

            $response = APIHelpers::createAPIResponse(false, $code, $message, new CourseResource($course));

        } catch (QueryException $exception) {
            $code = $exception->getCode();

            $message = $exception->getMessage();

            $response = APIHelpers::createAPIResponse(true, $code, $message, null);
        }

        return new JsonResponse($response, $course ? Response::HTTP_CREATED : Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Display the specified resource.
     *
     * @param Course $course
     * @return JsonResponse
     */
    public function show(Course $course)
    {
        try {
            $code = Response::HTTP_FOUND;
            $message = "Course Found!";
            $response = APIHelpers::createAPIResponse(false, $code, $message, new CourseResource($course));
        } catch (QueryException $exception) {
            $code = $exception->getCode();
            $message = $exception->getMessage();
            $response = APIHelpers::createAPIResponse(true, $code, $message, null);
        }

        return new JsonResponse($response, $course ? Response::HTTP_FOUND : Response::HTTP_NO_CONTENT);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param CourseRequest $request
     * @param Course $course
     * @return JsonResponse
     */
    public function update(CourseRequest $request, Course $course)
    {
        $isUpdated = false;

        try {
            $isUpdated = $course->update([
                'course_name' => $request->course_name ? $request->course_name : $course->course_name,
                'course_code' => $request->course_code ? $request->course_code : $course->course_code
            ]);

            $code = Response::HTTP_CREATED;
            $message = "Course Updated Successfully!";
            $response = APIHelpers::createAPIResponse(false, $code, $message, new CourseResource($course));

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
     * @param Course $course
     * @return JsonResponse
     */
    public function destroy(Course $course)
    {
        $isDeleted = false;
        try {
            $isDeleted = $course->delete();
            $code = Response::HTTP_OK;
            $message = "Course Deleted Successfully";
            $response = APIHelpers::createAPIResponse(false, $code, $message, null);
        } catch (QueryException $exception) {
            $code = $exception->getCode();
            $message = $exception->getMessage();
            $response = APIHelpers::createAPIResponse(true, $code, $message, null);
        }

        return new JsonResponse($response, $isDeleted ? Response::HTTP_OK : Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
