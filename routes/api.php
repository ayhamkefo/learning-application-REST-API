<?php

use App\Http\Controllers\PathController;
use App\Http\Controllers\ConceptController;
use App\Http\Controllers\AuthUser;
use App\Http\Controllers\ChoiceController;
use App\Http\Controllers\PreformancesContrroler;
use App\Http\Controllers\QuestionController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthUser::class, 'register']);
    Route::post('login', [AuthUser::class, 'login']);
    Route::delete('logout', [AuthUser::class, 'logout'])->middleware('auth:sanctum');
    Route::get('user', [AuthUser::class, 'getCurrentUser'])->middleware('auth:sanctum');
});
Route::prefix('admin')->middleware(['admin', 'auth:sanctum'])->group(function () {
    Route::resource('paths', PathController::class);
    Route::resource('concepts', ConceptController::class);
    Route::resource('questions', QuestionController::class);
    Route::get('review-questions', [QuestionController::class, 'reviweQuestion']);
    Route::patch('questions/{question_id}/approved', [QuestionController::class, 'approvedQuestion']);
    Route::patch('questions/{question_id}/reject', [QuestionController::class, 'rejectQuestion']);
    Route::post('questions/{question_id}/choices', [ChoiceController::class, 'store']);
    Route::get('questions/{question_id}/choices', [ChoiceController::class, 'getQuestionChoices']);
    
});
Route::prefix('student')->middleware(['student', 'auth:sanctum'])->group(function () {
    Route::resource('paths', PathController::class)->only('index', 'show');
    Route::resource('concepts', ConceptController::class)->only('index', 'show');
    Route::post('questions/{question_id}/choices', [ChoiceController::class, 'store']);
    Route::get('questions/{question_id}/choices', [ChoiceController::class, 'getQuestionChoices']);
    Route::resource('questions', QuestionController::class)->except('update');
    Route::get('student-questions', [QuestionController::class, 'getUserQuestions']);
    Route::get('user-preformance', [PreformancesContrroler::class,'increaseQuestionsSolved']);
    Route::Post('update-profile/{userID}',[AuthUser::class,'updateProfile']);
    Route::Post('change-password/{userID}',[AuthUser::class,'changeProfile']);
});
