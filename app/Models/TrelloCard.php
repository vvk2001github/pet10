<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrelloCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'trello_group_id',
        'task',
        'sort',
    ];

    public function group(): BelongsTo
    {
        return $this->belongsTo(TrelloGroup::class);
    }
}
