<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\static_data\AppStrings;
use App\static_data\CategoryData;

//use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class TestController extends Controller
{
    public function view(Request $request)
    {

//
        $data = QueryBuilder::for(Item::class)
            ->allowedFilters([
                AllowedFilter::callback('value', function (Builder $query, $value) {
                    $query->where('name', 'LIKE', "%$value%")
                        ->orWhere('name_ar', 'LIKE', "%$value%");
                })
            ])
            ->with('category')
            ->paginate(5);
//            ->get();

        return $this->successResponse($data, AppStrings::success);

//        $query = Item::query();

//        $data = QueryBuilder::for($query)
//            ->allowedFilters([
//                AllowedFilter::partial('name'),
//                AllowedFilter::beginsWithStrict('name'),
//                AllowedFilter::endsWithStrict('name'),
//                AllowedFilter::partial('name_ar'),
//            ])
//            ->get();
//        return $this->successResponse($data, AppStrings::success);
//        // Get the image file from the specified disk
//        $imageContent = Storage::disk($disk)->get($filePath);
//
//        // Open an image from the content
//        $img = Image::make($imageContent);
//
//        // Resize the image to the specified width and height
//        $img->resize($width, $height);
//
//        // Save the image back to the storage with reduced quality
//        Storage::disk($disk)->put($filePath, $img->encode('jpg', $quality)->__toString());
//
//        // Return the path to the resized image
//        return $filePath;


//        return Schema::getColumnListing('orders');
//
//        $cat = CategoryData::$categories[0];
//        $cat['image'] = 'image';
//        return response()->json($cat);
    }
}

