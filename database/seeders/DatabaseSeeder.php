<?php

namespace Database\Seeders;


use App\Models\Category;
use App\Models\Favorite;
use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\PersonalAccessToken;

class DatabaseSeeder extends Seeder
{

    public function run()
    {
        Category::unguard();
        Item::unguard();
        User::unguard();
        Favorite::unguard();
        PersonalAccessToken::unguard();

        //disable foreign key check for this connection before running seeders
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Category::truncate();
        Item::truncate();
        User::truncate();
        Favorite::truncate();
        PersonalAccessToken::truncate();

        User::factory(5)->create();

        $this->call([
            CategorySeeder::class,
            ItemSeeder::class,
        ]);

        Favorite::factory(20)->create();


        // supposed to only apply to a single connection and reset it's self
        // but I like to explicitly undo what I've done for clarity
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        Category::reguard();
        Item::reguard();
        Favorite::reguard();
        User::reguard();
        PersonalAccessToken::reguard();
    }
}
