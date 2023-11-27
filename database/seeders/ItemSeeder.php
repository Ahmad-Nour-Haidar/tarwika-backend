<?php

namespace Database\Seeders;

use App\Models\Item;
use App\static_data\ItemData;
use App\Traits\StoreStaticData;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{

    use StoreStaticData;

    private $folder = 'images/items';
    private $disk = 'storage';


    public function run()
    {
        $this->deleteDirectory($this->folder);

        foreach (ItemData::$foods as $food) {
            $price = rand(12, 35);
            Item::create([
                'name' => $food['name'],
                'name_ar' => $food['name_ar'],
                'image' => $this->storeImage($food['name'], $this->disk, $this->folder),
                'description' => $food['description'],
                'description_ar' => $food['description_ar'],
                'category_id' => $food['category_id'],
                'price' => [
                    'large' => $price,
                    'medium' => $price - 3,
                    'small' => $price - 6,
                ],
            ]);
        }
    }
}
