<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Resources\User as UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function signup(Request $request) {
       /* $request->validate([
           'username' => 'required|string|unique:users',
           'email' => 'required|string|email|unique:users',
           'password' => 'required|string|confirmed'
        ]);*/

        $validator = Validator::make($request->all(), [
            'username' => 'required|string|unique:users',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed'
        ]);

        if ($validator->fails()) {

            return response()->json($validator->errors(), 422);
        }

        $user = new User([
           'username' => $request->username,
           'email' => $request->email,
           'password' => bcrypt($request->password)
        ]);

        $user->save();

        return response()->json([
            'email' => $user->email,
            "id" => $user->id,
        ], 201);
    }

    public function login(Request $request) {
        $request->validate([
           'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);

        $credentials = request(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            return response()->json(['errors' =>['authentication' => 'Incorrect email or password']], 401);
        }

        $user = $request->user();

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;

        if ($request->remember_me) {
            $token->expires_at = Carbon::now()->addWeeks(1);
        }

        $token->save();

        $user = User::where('email', $request->email)->first();

        return response()->json([

            'user' => new UserResource($user),
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString()

        ]);
    }

    public function logout(Request $request) {
        $request->user()->token()->revoke();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function user(Request $request) {
        return response()->json($request->user());
    }
}
