<?php

namespace App\Http\Controllers\Api;

use App\Profile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;

class ProfileController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $profile = Profile::where('user_id', auth()->user()->id)->first();

        $profile->first_name = $request->input('first_name');
        $profile->last_name = $request->input('last_name');

        $profile->save();

        return response()->json([
            'data' => [
                'message' => 'Profile - Updated Successfully.'
            ]
        ], 200);
    }
}
