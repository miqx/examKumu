<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function CreateUser(Request $data)
    {
        $validator = Validator::make($data->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors()->messages(), 500);
        }
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'api_token' => Hash::make(Str::random(80)),
        ]);

        return response()->json([
            'user_token' => $user->api_token,
            'user_email' => $user->email,
        ], 200);
    }

    public function GetToken(Request $data)
    {
        $validator = Validator::make($data->all(), [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors()->messages(), 500);
        }

        $user = User::where('email', $data->email)->first();

        if(!Hash::check($data->password, $user->password))
        {
            return response()->json(['message' => 'Incorrect Password'], 400);
        }

        return response()->json(['api_token' => $user->api_token], 200);
    }
}
