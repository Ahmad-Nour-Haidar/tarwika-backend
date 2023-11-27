<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Item;
use App\Models\User;
use App\static_data\AppStrings;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ItemController extends Controller
{
    public function view($categoryId)
    {
        $user = auth()->user();
        $favorites = $user->favorites;
        $items = Item::where('category_id', $categoryId)->get();
//        $items = QueryBuilder::for(Item::class)
//            ->where('category_id', $categoryId)
//            ->with('category')->get();
        $items->each(function ($item) use ($favorites) {
            $item->is_favorite = $favorites->contains($item);
            $item->category_name = $item->category->name;
            unset($item->category);
//            $item->category;
        });
        return $this->successResponse($items, AppStrings::success);
    }

    public function search()
    {
        $data = QueryBuilder::for(Item::class)
            ->allowedFilters([
                AllowedFilter::callback('search', function (Builder $query, $value) {
                    $query->where('name', 'LIKE', '%' . $value . '%')
                        ->orWhere('name_ar', 'LIKE', '%' . $value . '%');
                })
            ])->get();
        $favorites = auth()->user()->favorites;
        $data->each(function ($item) use ($favorites) {
            $item->is_favorite = $favorites->contains($item);
            $item->category_name = $item->category->name;
            unset($item->category);
        });
        return $this->successResponse($data, AppStrings::success);
    }
}
