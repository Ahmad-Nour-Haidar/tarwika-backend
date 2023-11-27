<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    protected $fillable = [
        'name',
        'name_ar',
        'image'
    ];

    protected $hidden = [
        'updated_at',
        'created_at',
    ];
}
