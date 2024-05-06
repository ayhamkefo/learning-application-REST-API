<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPerformance extends Model
{
    protected $fillable = [
        'question_solved' , 'points', 'user_id'
    ];
    use HasFactory;
}
