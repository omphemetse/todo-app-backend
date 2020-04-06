<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\User;
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
            'surname' => 'required',
            'cellphone' => 'required|numeric|digits:10',
            'branch_id' => 'required',
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $input = $request->all();
        $user = User::create($input);

        //TODO: get admin for this store
        //send mail to admin
        //Mail::to('mokgosi@gmail.com')->send(new NewUserRegistration($user));

        return $this->sendResponse($user, 'Account created successfully.');
    }

    public function login (Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user) {

            if (Hash::check($request->password, $user->password)) {

                //handle token exception
                try {
                    $token = $user->createToken('Password Grant Client')->accessToken;
                    $response = ['token' => $token];
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

    public function logout (Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();

        $response = 'You have been succesfully logged out!';
        return response($response, 200);
    }
}
