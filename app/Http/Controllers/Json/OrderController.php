<?php

namespace App\Http\Controllers\Json;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Order;
use App\OrderItem;
use App\Product;
use App\StockMoving;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        if ($request->has('customer') && !is_null($request->customer)) {
            $customer = explode(':', $request->customer);
            $customerType = $customer[0];
            $customerId = (int) $customer[1];

            $request->request->add(['customer_type' => $customerType]);
            $request->request->add(['customer_id' => $customerId]);
        }

        $this->validate($request, [
            'items' => 'required',
            'items.*.id' => 'required',
            'items.*.quantity' => 'required',
        ]);

        $items = Product::whereIn('id', collect($request->items)->pluck('id'))->get();

        $_items = collect($request->items)->map(function ($item) use ($items) {
            $_item = $items->where('id', $item['id'])->first();
            $__item = [];

            $__item['item_id'] = $_item->id;
            $__item['item_type'] = get_class($_item);
            $__item['item_name'] = $_item->name;
            $__item['item_price'] = round($_item->price, 2);
            $__item['item_qty'] = round($item['quantity'], 2);
            $__item['total'] = round($item['price'] * $item['quantity'], 2);

            return $__item;
        });

        $order = Order::create([
            'branch_id' => auth()->user()->branch_id,
            'code' => Order::generateCode(),
            'cashier_id' => $request->user()->id,
            'customer_id' => $request->customer_id,
            'customer_type' => $request->customer_type,
            'total_qty' => $_items->sum('item_qty'),
            'total_amount' => $_items->sum('total'),
            'status' => Order::STATUS_PAID,
        ]);

        $order->items = $_items->map(function ($item) use ($order) {
            $item['order_id'] = $order->id;

            $_item = collect($item)->only([
                'order_id', 'item_id', 'item_type', 'item_name', 'item_price', 'item_qty', 'total'
            ]);

            $item = OrderItem::create($_item->toArray());

            $item->updateStock();

            return $item;
        });



        return response()->json([
            'message' => 'Transaksi berhasil.',
            'data' => $order,
        ]);
    }
}
