<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Traits\Response;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    use Response;
    public function login(Request $request)
    {
        $validation = Validator::make($request->input(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validation->fails())
            return response()->json([
                'status' => 'error',
                'message' => $validation->errors()
            ], 400);


        try {
            $user = User::query()
                ->email($request->input('email'))
                ->password($request->input('password'))->first();

            if (!$user) return  $this->failed('Email/Password is invalid', 401);

            $token = $user->createToken('auth_token')->plainTextToken;

            return $this->success(data: [
                'token' => $token,
                'user' => $user
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return $this->failed('Something went wrong');
        }
    }


    public function getUser(Request $request)
    {
        return $this->success(data: $request->user());
    }

    public function register(Request $request)
    {
        $validation = Validator::make($request->input(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validation->fails())
            return response()->json([
                'status' => 'error',
                'message' => $validation->errors()
            ], 400);

        if (User::email($request->email)->exists())
            return $this->failed('Email already exists', 400);


        try {
            $user = User::create($request->input());

            $token = $user->createToken('auth_token')->plainTextToken;

            return $this->success(data: [
                'token' => $token,
                'user' => $user
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return $this->failed('Something went wrong');
        }
    }

    public function logout(Request $request)
    {
        $user = $request->user();

        if ($user) {
            $user->tokens()->delete();
            return $this->success();
        }

        return $this->failed('Unauthorized', 401);
    }



    public function postsByAuthor(User $user)
    {
        $posts = $user->posts()->with('category', function ($query) {
            return $query->select('id', 'title', 'slug');
        })->pagination();

        return $this->success(data: [
            'author' => $user,
            'posts' => $posts
        ]);
    }
}
