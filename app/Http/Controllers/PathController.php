<?php

namespace App\Http\Controllers;

use App\Models\ProgrammingPath;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PathController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'status' => 200,
            'paths' => ProgrammingPath::all()
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'title' => 'required|string',
                'description' => 'required|string',
                'sources' => 'required|string'
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => $validator->messages()
            ], 422);
        }
        ProgrammingPath::create([
            'title' => $request->title,
            'description' => $request->description,
            'sources' => $request->sources
        ]);
        return response()->json([
            'status' => 200,
            'message' => 'programming path add successfully'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $path = ProgrammingPath::find($id);
        if ($path) {
            return response()->json([
                'status' => 200,
                'path' => $path
            ],200);
        }
        return response()->json(['status' => 404,'message' => 'this programming path was not found'], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'title' => 'required|string',
                'description' => 'required|string',
                'sources' => 'required|string'
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => $validator->messages()
            ], 422);
        }
        $path = ProgrammingPath::find($id);
        if ($path) {
            $path->title = $request->title;
            $path->description = $request->description;
            $path->sources = $request->sources;
            $path->save();
            return response()->json([
                'status' => 200,
                'message' => 'programming path updated successfully'
            ],200);
        }
        return response()->json([
            'status' => 404,
            'message' => 'this programming path was not found'
        ], 404);
    }  

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $path = ProgrammingPath::find($id);
        if($path){
            $path->delete();
            return response()->json([
                'status' => 200,
                'message' => 'programming path deleted successfully'
            ],200);
        }
        return response()->json([
            'status' => 404,
            'message' => 'this programming path was not found'
        ], 404); 
    }
}
