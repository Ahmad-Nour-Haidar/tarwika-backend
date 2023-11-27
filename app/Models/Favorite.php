<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'user_id',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function scopeDeleteFavorite($query, $userId, $itemId)
    {
        return $query
            ->where('item_id', $itemId)
            ->where('user_id', $userId);
    }
}
