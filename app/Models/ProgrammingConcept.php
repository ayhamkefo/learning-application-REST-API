<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgrammingConcept extends Model
{
    use HasFactory;
    protected $fillable = [
        'topic_name',
        'title',
        'explanation',
        'sources'
    ];
}
