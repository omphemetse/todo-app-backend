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
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $profile = Profile::find($id);

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
