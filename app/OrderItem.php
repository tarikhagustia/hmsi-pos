<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $guarded = [];

    public function item()
    {
        return $this->morphTo();
    }

    public function updateStock()
    {
        $stock = $this->item->stocks;
        $stockBefore = $stock->qty;
        $stock->qty -= $this->item_qty;
        $stock->save();

        // Simpan Ke Histori
        StockMoving::create([
            'product_stock_id' => $stock->id,
            'amount' =>  -$this->item_qty,
            'stock_after' => $stock->qty,
            'stock_before' => $stockBefore,
            'movable_id' => $this->id,
            'movable_type' => get_class($this),
            'comment' => 'Transaksi POS'
        ]);

        return $stock;
    }
}
