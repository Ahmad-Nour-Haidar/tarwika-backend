<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FavoriteFactory extends Factory
{
    public function definition()
    {
        return [
            'item_id' => Item::all()->random()->id,
            'user_id' => User::all()->random()->id,
        ];
    }
}
