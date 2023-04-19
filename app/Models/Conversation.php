<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable=[
        'user_id',
        'name',
        'descr',
        'last_time_message',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
