<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function getAllUsers(Request $request)
    {
        //
        $limit = $request->query->get("limit");
        $offset = $request->query->get("offset");
        //
        $users = User::select(
            'id',
            'first_name',
            'last_name',
            'email',
            'age',
            'avatar',
            'gender'
        )->limit($limit)
            ->offset($offset)
            ->get();
        //
        return response()->json(['users' => $users], Response::HTTP_OK);
    }
    public function getUser(User $user)
    {
        if ($user) {
            return response()->json(['user' => $user], Response::HTTP_OK);
        }
        return response()->json(['message' => 'user not found'], Response::HTTP_NOT_FOUND);
    }
    public function login(Request $resquest)
    {
        $data = $resquest->validate([
            'email' => ['required', 'email', 'exists:user,email'],
            'password' => ['required', 'min:8'],
        ]);

        $email = $resquest->input('email');
        $password = $resquest->input('password');

        $token = auth()->attempt(['email' => $email, 'password' => $password]);
        //
        if ($token) {
            $user = Auth::user();
            //
            $data = [
                'token' => $token,
                'user' => $user,
            ];
            //
            return response()->json($data, Response::HTTP_OK);
        }
        return response()->json(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
    }
    public function createUser(Request $resquest)
    {

        $data = $resquest->validate([
            'first_name' => ['required', 'string', 'min:1'],
            'last_name' => ['required', 'string', 'min:1'],
            'password' => ['required', 'min:8'],
            'age' => ['required', 'integer', 'between:1,120'],
            'email' => ['required', 'email', 'unique:users'],
            'avatar' => ['nullable', 'image', 'mimes:png,jpeg,gif,jpg'],
            'gender' => ['required', 'in:male:female'],
        ]);

        if ($data) {
            $user = User::create([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'password' => Hash::make($data['password']),
                'age' => $data['age'],
                'email' => $data['email'],
                'avatar' => $data['avatar'] ?? NULL,
                'gender' => $data['gender'],
            ]);
            return response()->json($user, Response::HTTP_CREATED);
        }
        return response()->json(['message' => 'Can\'t add another user'], Response::HTTP_BAD_REQUEST);
    }
    public function updateUser(User $user, Request $resquest)
    {

        $data = $resquest->validate([
            'first_name' => ['sometimes', 'string', 'min:1'],
            'last_name' => ['sometimes', 'string', 'min:1'],
            'password' => ['sometimes', 'min:8'],
            'age' => ['sometimes', 'integer', 'between:1,120'],
            'email' => ['sometimes', 'email', 'unique:users'],
            'avatar' => ['sometimes', 'image', 'mimes:png,jpeg,gif,jpg'],
            'gender' => ['sometimes', 'in:male:female'],
        ]);
        if ($user->update($data)) {
            return response()->json($user, Response::HTTP_OK);
        }
        return response()->json(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
    }
    public function deleteUser(User $user)
    {
        if ($user->delete()) {
            return response()->json($user, Response::HTTP_NO_CONTENT);
        }
        return response()->json(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
    }
}
