<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use Uuids;
    use HasFactory;

    protected $fillable = [
        'question_id',
        'user_id',
        'answer',
        'score',
        'question',
        'comment'
    ];
}
