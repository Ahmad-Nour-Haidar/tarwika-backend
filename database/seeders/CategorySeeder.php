<?php

namespace Database\Seeders;

use App\Models\Category;
use App\static_data\CategoryData;
use App\Traits\StoreStaticData;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{

    use StoreStaticData;

    private $folder = 'images/categories';
    private $disk = 'storage';

    public function run()
    {
        $this->deleteDirectory($this->folder);
        foreach (CategoryData::$categories as $category) {
            $category['image'] = $this->storeImage($category['name'], $this->disk, $this->folder);
            Category::create($category);
//            Category::create([
//                'name' => $category['name'],
//                'name_ar' => $category['name_ar'],
//                'image' => $this->storeImage($category['name'], $this->disk, $this->folder),
//            ]);
        }
//        Category::insert(CategoryData::$categories);
    }
}
