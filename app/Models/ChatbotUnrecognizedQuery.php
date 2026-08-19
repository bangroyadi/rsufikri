<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatbotUnrecognizedQuery extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'raw_query',
        'normalized_query',
        'detected_intent',
        'confidence_score',
        'is_resolved',
        'admin_notes',
    ];

    protected $casts = [
        'confidence_score' => 'float',
        'is_resolved'      => 'boolean',
    ];
}
