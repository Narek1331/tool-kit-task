<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;

class AdminController extends Controller
{
     /**
     * Create a new AdminController instance.
     *
     * @return void
     */
    public function __construct(UserService $user_service)
    {
        $this->user_service = $user_service;
        $this->middleware('admin');
    }

     /**
     * @OA\Get(
     * tags={"Admin"},
     *      path="/api/admin/users",
     *      security={{"bearer_token":{}}},
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *     @OA\Response(
     *          response=422,
     *          description="Unprocessable Content"
     *      )
     *     ),
     *     ),
     */
    public function users(){

        $users = $this->user_service->all();

        return response()->json([
            'status' => true,
            $users
        ],200);
    }
}
