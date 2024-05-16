<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgrammingPath extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'sources',
        'roles',
        'challenges',
        'interests',
        'frameworks',
        'steps_to_learn'
    ];
}
