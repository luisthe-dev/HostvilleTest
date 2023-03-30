<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAdminRequest;
use App\Models\Admin;
use App\Models\Courses;
use App\Models\Program;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{

    public function createAdmin(CreateAdminRequest $request)
    {

        $admin = new Admin([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $admin->save();

        return SuccessResponse('Admin Account Created Successfully', $admin, 201);
    }

    public function loginAdmin(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6'
        ]);

        $admin = Admin::where(['email' => $request->email])->first();

        if (!$admin) return ErrorResponse('Invalid Admin Details');

        if (!Hash::check($request->password, $admin->password)) return ErrorResponse('Invalid Admin Details');

        $adminToken = $admin->createToken('Personal Access Token', ['superAdmin']);

        $accessToken = $adminToken->accessToken;
        $accessToken->expires_at = Carbon::now()->addWeeks(4);

        $accessToken->save();

        $responseData = [
            'access_token' => explode('|', $adminToken->plainTextToken)[1],
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $adminToken->accessToken->expires_at
            )->toDateTimeString(),
            'adminDetails' => $admin
        ];

        return SuccessResponse('Admin Logged In Successfully', $responseData);
    }

    public function adminStats()
    {
        $users = User::count();
        $programs = Program::count();
        $courses = Courses::count();

        $response = array(
            'Users' => $users,
            'Programs' => $programs,
            'Courses' => $courses
        );

        return SuccessResponse('', $response);
    }

    public function getUsers()
    {
        return User::paginate(10);
    }
}
