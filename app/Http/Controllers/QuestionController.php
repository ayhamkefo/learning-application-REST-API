<?php

namespace App\Http\Controllers;


use App\Models\InterviewQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'status' => 200,
            'questions' => InterviewQuestion::with('choices')->where('is_approved', true)->get()
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
                'question_text' => 'required|string',
                'topic_name' => 'required|string',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => $validator->messages()
            ], 422);
        }
        $question = new InterviewQuestion;
        $question->question_text = $request->question_text;
        $question->topic_name = $request->topic_name;
        $question->is_approved = Auth::user()->role === 'admin';
        $question->user_id = Auth::user()->id;
        $question->save();
        return response()->json([
            'status' => 200,
            'message' => 'interview question add successfully'
        ], 200);
    }

    public function approvedQuestion($qustion_id)
    {
        $question = InterviewQuestion::find($qustion_id);
        if ($question) {
            $question->is_approved = true;
            $question->save();
            return response()->json([
                'status' => 200,
                'message' => 'interview question approved'
            ], 200);
        }
        return response()->json([
            'status' => 404,
            'message' => 'this interview question was not found'
        ], 404);
    }
    public function rejectQuestion($qustion_id)
    {
        $question = InterviewQuestion::find($qustion_id);
        if ($question) {
            $question->delete();
            return response()->json([
                'status' => 200,
                'message' => 'interview question rejected'
            ], 200);
        }
        return response()->json([
            'status' => 404,
            'message' => 'this interview question was not found'
        ], 404);
    }
    public function reviweQuestion()
    {
        return response()->json([
            'status' => 200,
            'questions' => InterviewQuestion::where('is_approved', false)->get()
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $question = InterviewQuestion::find($id);
        if ($question && $question->is_approved) {
            return response()->json([
                'status' => 200,
                'question' => $question->with('choices')->get()
            ], 200);
        }
        return response()->json([
            'status' => 404,
            'message' => 'this interview question was not found'
        ], 404);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'question_text' => 'required|string',
                'topic_name' => 'required|string',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => $validator->messages()
            ], 422);
        }
        $question = InterviewQuestion::find($id);
        if ($question) {
            $question->question_text = $request->question_text;
            $question->topic_name = $request->topic_name;
            $question->save();
            return response()->json([
                'status' => 200,
                'message' => 'question updated successfully'
            ], 200);
        }
        return response()->json([
            'status' => 404,
            'message' => 'this interview question was not found'
        ], 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $question = InterviewQuestion::find($id);
        if (!$question) {
            return response()->json([
                'status' => 404,
                'message' => 'this interview question was not found'
            ], 404);
        }
        if (Auth::user()->role === 'admin' || Auth::user()->id === $question->user_id) {
            $question->delete();
            return response()->json([
                'status' => 200,
                'message' => 'question deleted successfully'
            ], 200);
        }
        return response()->json([
            'status' => 403,
            'message' => 'Unauthorized action'
        ],403);
    }
    public function getUserQuestions(){
        return response()->json([
            'status' => 200,
            'questions' => InterviewQuestion::where('user_id','=',Auth::user()->id)->get(),
        ]);
    } 
}
