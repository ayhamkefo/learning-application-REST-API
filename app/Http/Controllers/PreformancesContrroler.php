<?php

namespace App\Http\Controllers;

use App\Models\UserPerformance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PreformancesContrroler extends Controller
{
    public function increaseQuestionsSolved()
    {
        // $user = $request->user();
        // if(!$user){
        //     return response()->json([
        //         'status' => 404,
        //         'message' => 'user not found'
        //     ],404);
        // }
        $user_id = Auth::user()->getAuthIdentifier();
        $in_table= UserPerformance::find($user_id);
        print($in_table);
        if ($in_table) {
            UserPerformance::where('user_id', $user_id)->increment('question_solved');
            return response()->json([
                'status' => 200,
                'message' => 'user preformaces updated successfully pls',
            ], 200);
        } else {
            UserPerformance::create([
                'question_solved' => 1,
                'points' => 1,
                'user_id' => $user_id,
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'user preformaces updated successfully',
            ], 200);
            
        }
    }
}
