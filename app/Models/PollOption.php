<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PollOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'poll_id',
        'option'
    ];

    public function poll()
    {
        return $this->belongsTo(LivePoll::class, 'poll_id');
    }

    public function responses()
    {
        return $this->hasMany(PollResponse::class, 'option_id');
    }
} 