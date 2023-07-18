<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SignupRequest;
use App\Http\Requests\Auth\SigninRequest;
use App\Services\UserService;

/**
 * @OAS\SecurityScheme(
 *      securityScheme="bearer_token",
 *      type="http",
 *      scheme="bearer"
 * )
 */
class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(UserService $user_service)
    {
        $this->user_service = $user_service;
        $this->middleware('auth:api', ['except' => ['login','signup']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    /**
     * @OA\Post(
     * tags={"Auth"},
     * @OA\RequestBody(
     *   @OA\JsonContent(
     *      type="object",
     *     @OA\Property(property="email", type="string"),
     *     @OA\Property(property="password", type="string")
     *  )
     *  ),
     *      path="/api/auth/login",
     *      description="login",
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *     @OA\Response(
     *          response=422,
     *          description="Unprocessable Content"
     *      )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Ok"
     *      )
     *     ),
     */
    public function login(SigninRequest $data)
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    /**
     *  @OA\Post(
     *      tags={"Auth"},
     *      path="/api/auth/me",
     *      security={{"bearer_token":{}}},
     *      @OA\Response(
     *          response=200,
     *          description="Ok"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *  )
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
        /**
     *  @OA\Post(
     *      tags={"Auth"},
     *      path="/api/auth/logout",
     *      security={{"bearer_token":{}}},
     *      @OA\Response(
     *          response=200,
     *          description="Ok"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *  )
     */
    public function logout()
    {
        // auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    /**
     *  @OA\Post(
     *      tags={"Auth"},
     *      path="/api/auth/refresh",
     *      security={{"bearer_token":{}}},
     *      @OA\Response(
     *          response=200,
     *          description="Ok"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *  )
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    /**
     * Signup user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
       /**
     * @OA\Post(
     *  tags={"Auth"},
     *  @OA\RequestBody(
     *   @OA\JsonContent(
     *      type="object",
     *     @OA\Property(property="email", type="string"),
     *     @OA\Property(property="password", type="string"),
     *     @OA\Property(property="phone_number", type="string"),
     *     @OA\Property(property="name", type="string")
     *  )
     *  ),
     *      path="/api/auth/signup",
     *      description="signup",
     *      @OA\Response(
     *          response=201,
     *          description="Cretaed",
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Content"
     *      )
     *     ),
     *
     */
    public function signup(SignupRequest $data)
    {
        $user = $this->user_service->store($data['name'],$data['email'],$data['phone_number'],$data['password']);

        return response()->json([
            'status' => true,
            'message' => 'User registered successfully, login'
        ],201);

    }
}
