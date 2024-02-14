<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\LoginRequest;
use App\Models\User;
use App\Repositories\Management\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use OpenApi\Annotations as OA;

class AuthController extends Controller
{
    public $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }    /**
 * Login The User
 * @param  Request  $request
 * @return User
 */

    /**
     * @OA\Post(
     *      path="/api/auth/login",
     *      operationId="apiLogin",
     *      tags={"Authentication"},
     *      summary="Login",
     *      description="Login with sanctum guard",
     *     @OA\Parameter(
     *         description="Users email",
     *         in="query",
     *         required=true,
     *         name="email",
     *         @OA\Schema(format="email"),
     *     ),
     *     @OA\Parameter(
     *         description="Users password",
     *         in="query",
     *         required=true,
     *         name="password",
     *         @OA\Schema(format = "password"),
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="OK",
     *           @OA\JsonContent(
     *                  type="object",
     *                  @OA\Property(
     *                       type="status",
     *                       default="true",
     *                       description="",
     *                       property="status"
     *                  ),
     *                  @OA\Property(
     *                       type="message",
     *                       default="User logged in successfully",
     *                       description="",
     *                       property="message"
     *                  ),
     *                  @OA\Property(
     *                       type="token",
     *                       default="1|4tRvz5YdLzZP1k50IpSeqhlyAvXEp150OJYNFEFV",
     *                       description="",
     *                       property="token"
     *                  )
     *          )
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized",
     *           @OA\JsonContent(
     *                  type="object",
     *                  @OA\Property(
     *                       type="status",
     *                       default="false",
     *                       description="",
     *                       property="status"
     *                  ),
     *                  @OA\Property(
     *                       type="message",
     *                       default="Email & Password does not match with our record.",
     *                       description="",
     *                       property="message"
     *                  )
     *          )
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Content",
     *           @OA\JsonContent(
     *                  type="object",
     *                  @OA\Property(
     *                       type="message",
     *                       default="The email/password  field is required.",
     *                       description="",
     *                       property="email/password"
     *                  )
     *          )
     *       )
     *     )
     */
    public function loginUser(LoginRequest $request)
    {
        $input = $request->validated();
        if (!Auth::attempt($input)) {
            return response()->json([
                'status' => false,
                'message' => __('auth.failed'),
            ], 401);
        }

        $user = auth()->user();

        return response()->json([
            'status' => true,
            'message' => __('auth.logged_in'),
            'token' => $user->createToken("apiLoginToken")->plainTextToken
        ]);
    }
}
