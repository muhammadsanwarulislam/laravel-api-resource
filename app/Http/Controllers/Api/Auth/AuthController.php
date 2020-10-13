<?php

namespace App\Http\Controllers\Api\Auth;

use App\Helpers\APIHelpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\SignInRequest;
use App\Http\Requests\SignUpRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;


class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt', ['except' => ['login', 'register']]);
    }

    public function allUsers()
    {
        try {
            $users = User::all();

            $code = Response::HTTP_FOUND;

            $message = $users->count() . " Users Found!";

            $response = APIHelpers::createAPIResponse(false, $code, $message, UserResource::collection($users));

        } catch (QueryException $exception) {

            $code = $exception->getCode();

            $message = $exception->getMessage();

            $response = APIHelpers::createAPIResponse(true, $code, $message, null);
        }

        return new JsonResponse($response, $code == Response::HTTP_FOUND ? Response::HTTP_FOUND : Response::HTTP_NO_CONTENT);

    }

    /**
     * @param SignInRequest $request
     * @return JsonResponse
     */

    public function login(SignInRequest $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (!$token = Auth::guard('api')->claims(['name' => 'Juyel'])->attempt($credentials)) {

            $code = Response::HTTP_UNAUTHORIZED;

            $message = "Credentials does not matches.";

            $response = APIHelpers::createAPIResponse(true, $code, $message, null);

            return new JsonResponse($response, $code);
        }

        return $this->createNewToken($token);
    }

    /**
     * @param SignUpRequest $request
     * @return JsonResponse
     */

    public function register(SignUpRequest $request)
    {
        $user = null;

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);

            $code = Response::HTTP_CREATED;
            $message = "User Successfully Registered.";
            $response = APIHelpers::createAPIResponse(false, $code, $message, new UserResource($user));

        } catch (QueryException $exception) {
            $message = $exception->getMessage();
            $code = $exception->getCode();
            $response = APIHelpers::createAPIResponse(true, $code, $message, null);

        }

        return new JsonResponse($response, $user ? Response::HTTP_CREATED : Response::HTTP_INTERNAL_SERVER_ERROR);
    }


    public function logout()
    {
        if (auth()->check()) {
            auth()->logout();
            $code = Response::HTTP_OK;
            $message = "User successfully signed out.";
            $response = APIHelpers::createAPIResponse(false, $code, $message, null);
        } else {
            $code = Response::HTTP_INTERNAL_SERVER_ERROR;
            $message = "You are not logged in.";
            $response = APIHelpers::createAPIResponse(true, $code, $message, null);
        }

        return new JsonResponse($response, $code);
    }

    public function refresh()
    {
        return $this->createNewToken(auth()->refresh());
    }


    /**
     * @return \Illuminate\Http\JsonResponse
     */

    public function userProfile()
    {
        if (auth()->user()) {
            $code = Response::HTTP_OK;
            $message = "User Profile Found.";
            $response = APIHelpers::createAPIResponse(false, $code, $message, new UserResource(auth()->user()));
        } else {
            $code = Response::HTTP_BAD_REQUEST;
            $message = "User Profile Not Found.";
            $response = APIHelpers::createAPIResponse(true, $code, $message, null);

        }
        return new JsonResponse($response, $code);
    }

    protected function createNewToken($token)
    {

        if ($token != null) {

            $code = Response::HTTP_OK;

            $message = "Login Success";

            $access_token = [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60 * 24 * 30,
                'user' => new UserResource(auth()->user())
            ];

            $response = APIHelpers::createAPIResponse(false, $code, $message, $access_token);

            return new JsonResponse($response, $code);
        }

    }


}
