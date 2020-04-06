<?php

namespace App\Http\Controllers\Api;

use App\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use Validator;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::with('user')->get();

        return response()->json(['data' => $tasks], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'title' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [
                    'message' => 'Task - Create Task Failed.'
                ]
            ], 400);
        }

        $input['user_id'] = auth()->user()->id;
        $task = Task::create($input);

        return response()->json([
            'data' => [
                'message' => 'Success',
                'id' => $task->id,]
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $task = Task::find($id);

        if ($task) {

            $input = $request->all();

            $validator = Validator::make($input, [
                'title' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'data' => [
                        'message' => 'Task - Update Failed.'
                    ]
                ], 400);
            }
            $task->title = $request->input('title');
            $task->save();

            return response()->json([
                'data' => [
                    'message' => 'Task - Updated Successfully.'
                ]
            ], 200);

        } else {
            return response()->json([
                'message' => 'Task - Not found.'
            ], 404);
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function complete(Request $request, $id)
    {
        $task = Task::find($id);
        if ($task) {
            $task->complete = $request->input('complete');
            $task->save();
            return response()->json([
                'data' => [
                    'message' => 'Task - Updated Successfully.'
                ]
            ], 200);
        } else {
            return response()->json([
                'data' => [
                    'message' => 'Task - Not found.'
                ]
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::find($id);

        if ($task) {
            $task->delete();
            return response()->json(['data' => $task], 200);
        } else {
            return response()->json([
                'data' => [
                    'message' => 'Task - Not found.'
                ]
            ], 404);
        }
    }
}
