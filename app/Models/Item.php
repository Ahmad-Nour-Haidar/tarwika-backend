<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Spatie\QueryBuilder\Concerns\FiltersQuery;
use Spatie\QueryBuilder\QueryBuilder;

class Item extends Model
{
    use HasFactory;
    use  FiltersQuery;
//    use  QueryBuilder;

//    protected $allowedFilters = ['name', 'name_ar'];
//    protected $allowedSorts = ['created_at', 'name'];
//    protected $allowedIncludes = ['relationship'];

    protected $fillable = [
        'name',
        'name_ar',
        'description',
        'description_ar',
        'price',
        'image',
    ];

    protected $hidden = [
        'updated_at',
        'created_at',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'favorites',
            'item_id', 'user_id');
    }

    protected $casts = [
        'price' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    protected function data()
    {
        return Attribute::make(
            function ($value) {
                return json_decode($value, true);
            },
            function ($value) {
                return json_encode($value);
            }
        );
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites', 'item_id', 'user_id');
    }
}
