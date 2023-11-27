<?php

namespace App\Models;

use App\static_data\OrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_price',
        'total_count',
        'reservation_date_time',
        'persons',
//        'time',
    ];

    protected $hidden = [
        'updated_at',
        'created_at',
    ];

    public function scopeUserOrder($query, $userId)
    {
        return $query
            ->where('user_id', $userId)
            ->where('status', OrderStatus::waiting);
    }
}
