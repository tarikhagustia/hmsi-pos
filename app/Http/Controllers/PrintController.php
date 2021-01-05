<?php

namespace App\Http\Controllers;

use App\Order;
use App\StudentPayment;
use Illuminate\Http\Request;

class PrintController extends Controller
{
    public function print()
    {
        $receipt = null;

        if (request()->has('order') && request()->has('amount_paid')) {
            $receipt = $this->createFromOrder();
        } else if (request()->has('payment')) {
            $receipt = $this->createFromPayment();
        }

        return view('print.layout', compact('receipt'));
    }

    public function createFromOrder()
    {
        $order = Order::find(request()->order);
        $items = $order->items;

        $items->push((object) [
            'item_qty' => null,
            'item_name' => 'Subtotal',
            'item_price' => $items->sum('item_price'),
        ]);

        $items->push((object) [
            'item_qty' => null,
            'item_name' => 'Diskon',
            'item_price' => 0,
        ]);

        $items->push((object) [
            'item_qty' => null,
            'item_name' => 'Total Belanja',
            'item_price' => $order->total_amount,
        ]);

        $items->push((object) [
            'item_qty' => null,
            'item_name' => 'Jumlah Bayar',
            'item_price' => request()->amount_paid,
        ]);

        $items->push((object) [
            'item_qty' => null,
            'item_name' => 'Kembalian',
            'item_price' => request()->amount_paid - $order->total_amount,
        ]);

        $receipt = (object) [
            'company' => $order->cashier->branch->name,
            'address' => $order->cashier->branch->address,
            'time' => $order->created_at,
            'cashier' => $order->cashier->name,
            'items' => $items
        ];

        return $receipt;
    }

    public function createFromPayment()
    {
        $payment = StudentPayment::find(request()->payment);
        $items = collect([]);

        $items->push((object) [
            'item_qty' => 1,
            'item_name' => $payment->studentStudy->study->name,
            'item_price' => $payment->amount,
        ]);

        $items->push((object) [
            'item_qty' => null,
            'item_name' => 'Subtotal',
            'item_price' => $payment->amount,
        ]);

        $items->push((object) [
            'item_qty' => null,
            'item_name' => 'Jumlah Bayar',
            'item_price' => $payment->amount,
        ]);

        $receipt = (object) [
            'company' => $payment->studentStudy->study->branch->name,
            'address' => $payment->studentStudy->study->branch->address,
            'time' => $payment->created_at,
            'cashier' => $payment->studentStudy->study->name,
            'items' => $items
        ];

        return $receipt;
    }
}
