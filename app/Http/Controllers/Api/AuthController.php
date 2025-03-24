<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use App\Http\Requests\Auth\LoginRequest;
//use App\Models\User;
use App\Repositories\User\User;
use App\Repositories\User\UserRepo;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\registerRequest;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
     use ApiResponser;
    private UserRepo $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepo;
    }

    public function login(LoginRequest $request)
    {

        // Retrieve the validated input data...
        $validated = $request->validated();
        $credentials = $request->only('email', 'password');

        $user = User::where('email', $credentials['email'])->first();

        if($user){

            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                $data = ['token' => $token , "user" => $user];
                return $this->success($data, "login successfully", 200);
            } else {
                $data = [];
                return $this->success($data, "Password mismatch", 422);
            }

        }
        
        return $this->error("unauthorized", 401);
    }


    public function register(registerRequest $request)
    {
        // Retrieve the validated input data...
        $validated = $request->validated();
    
        try {
            $input = $request->only('email', 'password' , 'name');
            $input['password'] = bcrypt($input['password']);
            $this->userRepository->create(new User(), $input);
            $data = [];
            return $this->success($data, "User registered successfully", 200);

        } catch (\Exception $e) {
            $message = $e->getMessage();
            return $this->error($message , 400) ;
        }

    }
    
    public function profile(Request $request)
    {
        $data = ["user" => $request->user('api')];
        return $this->success($data, "Get user successfully", 200);
    }

    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();
        $data = [];
        return $this->success($data, "You have been successfully logged out!", 200);
    }

}
