<?php

namespace App\Http\Controllers;

use App\Models\Choice;
use App\Models\InterviewQuestion;
use Brick\Math\BigInteger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChoiceController extends Controller
{
    public function store(Request $request, $question_id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'is_true' => 'required|boolean',
                'choice_text' => 'required|string'
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => $validator->messages()
            ], 422);
        }
        $question = InterviewQuestion::find($question_id);
        if ($question) {
            $choice = new Choice;
            $choice->is_correct = $request->is_true;
            $choice->choice_text =  $request->choice_text;
            $choice->interview_question_id = $question_id;
            $choice->save();
            return response()->json([
                'status' => 200,
                'message' => 'choice add successfully'
            ], 200);
        }
        return response()->json([
            'status' => 404,
            'message' => 'this interview question was not found'
        ], 404);
    }
    public function getQuestionChoices($question_id)
    {
        $question = InterviewQuestion::find($question_id);
        if ($question && $question->is_approved) {
            return response()->json([
                'status' => 200,
                'choices' => $question->choices()->get(),
            ]);
        }
        return response()->json([
            'status' => 404,
            'message' => 'this interview question was not found'
        ], 404);
    }
}
