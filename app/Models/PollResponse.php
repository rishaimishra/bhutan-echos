<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PollResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'poll_id',
        'user_id',
        'option_id'
    ];

    public function poll()
    {
        return $this->belongsTo(LivePoll::class, 'poll_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function option()
    {
        return $this->belongsTo(PollOption::class, 'option_id');
    }
} 