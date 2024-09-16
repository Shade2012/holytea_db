<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function register(Request $request)
    {
        // Custom validation logic
       $messages = [
            'name.required' => 'name dibutuhkan.',
            'email.required' => 'email dibutuhkan.',
            'email.unique' => 'email sudah ada.',
            'password.required' => 'password dibutuhkan.',
            'password.min' => 'password minimal 8 karakter',
        ];

        // Custom validation logic
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], $messages);
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors(),
            ], 422);
        }
    
        // Handle file upload
        $imageName = "";
        if ($request->hasFile('profile_picture')) {
            $imageName = time() . '.' . $request->profile_picture->extension();
            $request->profile_picture->move(public_path('images/users'), $imageName);
        } else {
            $imageName = null;
        }
    
        // Create the user
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'profile_picture' => $imageName,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
    
        // Create a token for the user
        $token = $user->createToken('holytea')->plainTextToken;
    
    

        return response()->json([
            'success' => true,
            'message' => 'User created successfully',
            'data' => $user,
            'token' => $token,
        ], 201);
    }

    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::where('email',$request->email)->first();
        
        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'The provided credentials are incorrect.',
            ], 401);
        }
        $token = $user->createToken('warmindo')->plainTextToken;
        $user->save();
        return response()->json([
            'success' => true,
            'message' => 'User login successfully',
            'user' => $user,
            'token' => $token,
        ], 200);
    }

    public function details()
    {
        $user = auth()->user();
        $user = User::where('id', $user->id)->first();
        $token = $user->currentAccessToken();
        return response()->json([
            'success' => true,
            'message' => 'User details',
            'user' => $user,
            'token' => $token,

        ], 200);
    }

    public function allUsers()
    {
        $user = User::all();
        return response()->json([
            'success' => true,
            'message' => 'User details',
            'user' => $user,
        ], 200);
    }
}
