<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParticipantResponse extends Model
{
    use HasFactory;

    protected $fillable = ['bank_id', 'participant_name', 'participant_email', 'position', 'token', 'responses', 'score', 'completed', 'started_at', 'completed_at'];

    protected $casts = [
        'responses' => 'array',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }
}
