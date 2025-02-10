<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Users\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserService
{
    protected $userRepository;
    
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(array $data)
    {
        try {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            return $user;
        } catch (\Exception $e) {
            // Log error
            Log::error($e);
            return null;
        }
    }

    public function login(array $credentials)
    {
        try {
            if (!$token = auth()->guard('api')->attempt($credentials)) {
                return null;
            }

            return $token;
        } catch (\Exception $e) {
            Log::error($e);
            return null;
        }
    }

    public function getAll()
    {
        return $this->userRepository->getAll();
    }
}