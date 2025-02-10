<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\UserService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class RegisterController extends Controller
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
    public function __invoke(RegisterRequest $request)
    {
        $validated = $request->validated();

        if(!$validated)
        {
            return $this->error("Validation Error.");
        }else{   
            $user = $this->userService->register([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $validated['password'], // Password sudah divalidasi dan sama dengan confirm_password
            ]);

            if ($user) {
                return $this->created($user, 'User registered successfully');
            } else {
                return $this->internalError('Failed to register user');

            }
        }
    }
}
