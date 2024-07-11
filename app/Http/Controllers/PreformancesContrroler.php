<?php

namespace App\Http\Controllers;

use App\Models\UserPerformance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PreformancesContrroler extends Controller
{
    public function increaseQuestionsSolved()
    {
        UserPerformance::where('user_id', Auth::user()->id)->increment('question_solved');
        return response()->json([
            'status' => 200,
            'message' => 'user preformaces updated successfully',
        ], 200);
    }
}
