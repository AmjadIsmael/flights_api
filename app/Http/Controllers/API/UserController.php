<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::all();
        return response()->json($user);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required|string|max:255",
            "email" => "required|email|unique:users",
            "password" => "required|string|min:8",
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $sanitizedData = [
            "name" => $validator->validated('name'),
            "email" => $validator->validated('email'),
            "password" => Hash::make($validator->validated('password')),
        ];

        $user = User::create($sanitizedData);
        return response()->json($user, 201);
    }
    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required|string|max:255",
            "email" => "required|email|unique:users,email," . $user->id,
            "password" => "required|string|min:8",
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $sanitizedData = [
            "name" => $validator->validated('name'),
            "email" => $validator->validated('email'),
            "password" => $request->has("password") ? Hash::make($validator->validated('password')) : $user->password,
        ];

        $user->update($sanitizedData);
        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(null, 0);
    }

    /*public function exportToExcel()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }
        */
}
