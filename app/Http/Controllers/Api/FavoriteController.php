<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\static_data\AppStrings;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function view()
    {
        $favorites = auth()->user()->favorites;
        $favorites->each(function ($favorite) {
            $favorite->is_favorite = true;
            $favorite->category_name = $favorite->category->name;
            unset($favorite->category);
            unset($favorite->pivot);
        });
        return $this->successResponse($favorites, AppStrings::success);
    }

    public function add(Request $request)
    {
        $userId = auth()->user()->id;
        $itemId = $request->input('item_id');
        $input = [
            'user_id' => $userId,
            'item_id' => $itemId,
        ];
        $fav = Favorite::where($input)->first();
        if (!$fav) {
            Favorite::create($input);
        }
        return $this->successResponse(null, AppStrings::success);
    }

    public function delete($itemId)
    {
        $userId = auth()->user()->id;
        Favorite::deleteFavorite($userId, $itemId)->delete();
        return $this->successResponse(null, AppStrings::success);
    }


//    public function addFavorite(Request $request)
//    {
//        $itemId = $request->input('item_id');
//        if ($itemId === null) {
//            return $this->badRequestResponse('item_id not sent');
//        }
//        auth()->user()->favorites()->attach($itemId);
//        return $this->successResponse(null, 'Item added to favorites');
//    }
//
//    public function removeFavorite($itemId)
//    {
//        if ($itemId === null) {
//            return $this->badRequestResponse('item_id not sent');
//        }
//        auth()->user()->favorites()->detach($itemId);
//        return $this->successResponse(null, 'Item removed from favorites');
//    }
}
