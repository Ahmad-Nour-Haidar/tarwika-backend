<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'item_id',
        'category_id',
        'count',
        'size'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function scopeUserCart($query, $userId, $itemId)
    {
        return $query
            ->where('item_id', $itemId)
            ->where('user_id', $userId)
            ->where('order_id', 0);
    }
}
