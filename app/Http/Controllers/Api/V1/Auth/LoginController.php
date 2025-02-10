<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\UserService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use ApiResponse;

    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    /**
     * Handle the incoming request.
     */
    public function __invoke(LoginRequest $request)
    {
        $validate = $request->validated();

        if(!$validate){
            return $this->error("Validation Error.");
        }else{
            $token = $this->userService->login($validate);

            if ($token) {
                return $this->success([
                    'user' => auth()->guard('api')->user(),
                    'token' => $token
                ], 'Login successful');
            } else {
                return $this->error('Invalid credentials');
            }
        }
    }
}
