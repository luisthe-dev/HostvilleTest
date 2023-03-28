<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function createUser(CreateUserRequest $request)
    {

        $user = new User([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        $user->save();

        return SuccessResponse('User Created Successfully', $user, 201);
    }

    public function loginUser(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6'
        ]);

        $user = User::where(['email' => $request->email])->first();

        if (!$user) return ErrorResponse('Invalid User Details');

        if (!Hash::check($request->password, $user->password)) return ErrorResponse('Invalid User Details');

        $userToken = $user->createToken('Personal Access Token', ['user']);

        $accessToken = $userToken->accessToken;
        $accessToken->expires_at = Carbon::now()->addWeeks(4);

        $accessToken->save();

        $responseData = [
            'access_token' => explode('|', $userToken->plainTextToken)[1],
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $userToken->accessToken->expires_at
            )->toDateTimeString(),
            'userDetails' => $user
        ];

        return SuccessResponse('User Logged In Successfully', $responseData);
    }
}
