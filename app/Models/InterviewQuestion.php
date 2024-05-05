<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterviewQuestion extends Model
{
    use HasFactory;
    protected $fillable = [
        'question_text',
        'topic_name',
    ];
    public function choices(){
        return $this->hasMany(Choice::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
