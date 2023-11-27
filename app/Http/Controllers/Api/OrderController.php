<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Cart;
use App\Models\Order;
use App\static_data\AppStrings;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

    public function view()
    {
        $userId = auth()->user()->id;
        $data = Order::userOrder($userId)->get();
        return $this->successResponse($data, AppStrings::success);
    }

    public function order(OrderRequest $request)
    {
        $userId = auth()->user()->id;
        $input = $request->validated();
        $input['user_id'] = $userId;
        $order = Order::create($input);
        if (!$order) {
            return $this->badRequestResponse(AppStrings::failure);
        }
//        $maxId = Order::max('id');
        $maxId = $order->id;
        Cart::
        join('items', 'carts.item_id', '=', 'items.id')
            ->where('carts.user_id', $userId)
            ->where('carts.order_id', 0)
            ->update([
                'carts.item_price' => DB::raw("JSON_UNQUOTE(JSON_EXTRACT(items.price, CONCAT('$.', carts.size)))"),
                'carts.order_id' => $maxId,
            ]);
        return $this->successResponse(null, AppStrings::success);
    }

    public function details($orderId)
    {
        $userId = auth()->user()->id;
        $data = DB::table('order_details')
            ->where('user_id', $userId)
            ->where('order_id', $orderId)->get();
        return $this->successResponse($data, AppStrings::success);
    }
}
