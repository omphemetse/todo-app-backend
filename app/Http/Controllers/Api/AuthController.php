<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\User;
use App\Profile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Validator;

class AuthController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [
                    'message' => 'User - Create User Failed.'
                ]
            ], 400);
        }

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        $user->profile()->save(new Profile);

        return response()->json([
            'data' => [
                'message' => 'User - Created Successfully.'
            ]
        ], 201);
    }

    public function login(Request $request)
    {
        $user = User::with('profile')->where('email', $request->email)->first();

        if ($user) {

            if (Hash::check($request->password, $user->password)) {

                //handle token exception
                try {
                    $token = $user->createToken('Password Grant Client')->accessToken;
                    $response = ['user'=>$user, 'token' => $token];
                } catch (\Exception $e) {
                    $response['error'] = 'Personal access client not found. Please create one.';
                    return response($response, 422);
                }

                return response($response, 200);
            } else {
                $response['error'] = "Password missmatch";
                return response($response, 422);
            }
        } else {
            $response['error'] = 'User does not exist';
            return response($response, 422);
        }
    }

    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();

        $response = 'You have been succesfully logged out!';
        return response($response, 200);
    }
}
