<?php

namespace App\Http\Controllers;

use App\Models\ProgrammingConcept;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ConceptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'status' => 200,
            'concepts' => ProgrammingConcept::all(),
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
                'topic_name' => 'required|string',
                'title' => 'required|string',
                'explanation' => 'required|string',
                'sources' => 'required|string'
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => $validator->messages()
            ], 422);
        }
        ProgrammingConcept::create([
            'topic_name' => $request->topic_name,
            'title' => $request->title,
            'explanation' => $request->explanation,
            'sources' => $request->sources
        ]);
        return response()->json([
            'status' => 200,
            'message' => 'programming concept add successfully'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $path = ProgrammingConcept::find($id);
        if ($path) {
            return response()->json([
                'status' => 200,
                'path' => $path
            ], 200);
        }
        return response()->json(['status' => 404,'message' => 'this programming concepts was not found'], 404);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'topic_name' => 'required|string',
                'title' => 'required|string',
                'explanation' => 'required|string',
                'sources' => 'required|string'
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => $validator->messages()
            ], 422);
        }
        $concept = ProgrammingConcept::find($id);
        if ($concept) {
            $concept->title = $request->title;
            $concept->explanation = $request->explanation;
            $concept->sources = $request->sources;
            $concept->topic_name = $request->topic_name;
            $concept->save();

            return response()->json([
                'status' => 200,
                'message' => 'programming concept updated successfully'
            ], 200);
        }

        return response()->json([
            'status' => 404,
            'message' => 'this programming concept was not found'
        ], 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $concept = ProgrammingConcept::find($id);
        if ($concept) {
            $concept->delete();
            return response()->json([
                'status' => 200,
                'message' => 'programming concept deleted successfully'
            ], 200);
        }
        return response()->json([
            'status' => 404,
            'message' => 'this programming concept was not found'
        ], 404);
    }
}
