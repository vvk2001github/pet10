<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable=[
        'user_id',
        'name',
        'descr',
        'last_time_message',
    ];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function messages():HasMany
    {
        return $this->hasMany(Message::class);
    }
}
