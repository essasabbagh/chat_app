<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // Get all users except the currently authenticated user
        $users = User::where('id', '!=', $request->user()->id)
            ->select('id', 'name', 'email', 'username', 'profile_picture', 'status')
            ->get();

        return response()->json($users);
    }
}
