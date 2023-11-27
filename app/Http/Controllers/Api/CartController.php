<?php

namespace App\Http\Controllers\Api;

use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCartRequest;
use App\Models\Cart;
use App\static_data\AppStrings;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{

    public function view()
    {
        $userId = auth()->user()->id;
        $data = DB::table('cart_view')
            ->where('user_id', $userId)
            ->get();
        return $this->successResponse($data, AppStrings::success);
    }


    public function store(StoreCartRequest $request)
    {
        $userId = auth()->user()->id;
        $itemId = $request->input('item_id');
        $categoryId = $request->input('category_id');
        $size = $request->input('size');
        $count = $request->input('count');

        $userCart = Cart::userCart($userId, $itemId)->first();

        if ($userCart == null && $count == '0') {
            return $this->successResponse(null, AppStrings::success);
        }
        if (!$userCart && $count != '0') {
            Cart::create([
                'user_id' => $userId,
                'item_id' => $itemId,
                'category_id' => $categoryId,
                'size' => $size,
                'count' => $count,
            ]);
            return $this->successResponse(null, AppStrings::success);
        }
        if ($count == '0') {
            $userCart->delete();
        } else {
            $userCart->update([
                'size' => $size,
                'count' => $count,
            ]);
        }
        return $this->successResponse(null, AppStrings::success);
    }


    public function countItems()
    {
        $userId = auth()->user()->id;
        $count = DB::table('cart_view')
            ->where('user_id', $userId)
            ->sum('count');

//        $itemPrice = DB::table('cart_view')
//            ->where('user_id', $userId)
//            ->sum(DB::raw('count * item_price'));

        $totalPrice = DB::table('cart_view')
            ->where('user_id', $userId)
            ->sum('total_price');


        $data = [
            'count' => $count,
            'total_price' => $totalPrice,
        ];
        return $this->successResponse($data, AppStrings::success);
    }

    public function getDetailsItem($itemId)
    {
//        return 0;
        $userId = auth()->user()->id;
        $data = Cart::where([
            'user_id' => $userId,
            'item_id' => $itemId,
            'order_id' => 0,
        ])
            ->first();
        return $this->successResponse($data, AppStrings::success);
    }

    public function delete($cartId)
    {
//        $userId = auth()->user()->id;
        $cart = Cart::where('id', $cartId)->first();
        if ($cart) {
            $cart->delete();
        }
        return $this->successResponse(null, AppStrings::success);
    }
}
