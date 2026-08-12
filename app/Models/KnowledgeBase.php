<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KnowledgeBase extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'intent',
        'question',
        'keywords',
        'synonyms',
        'answer',
        'priority',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'priority'  => 'integer',
    ];
}
