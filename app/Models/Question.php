<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['bank_id', 'question', 'option_a', 'option_b', 'option_c', 'option_d', 'correct_answer', 'correct_answer_text', 'order', 'type', 'image', 'audio'];

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }
}
