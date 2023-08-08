<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TrelloGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'sort',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function trello_cards(): HasMany
    {
        return $this->hasMany(TrelloCard::class)->orderBy("sort");
    }
}
