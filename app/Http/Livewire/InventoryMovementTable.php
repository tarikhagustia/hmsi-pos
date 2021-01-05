<?php

namespace App\Http\Livewire;

use App\StockMoving;
use Kdion4891\LaravelLivewireTables\Column;
use Kdion4891\LaravelLivewireTables\TableComponent;

class InventoryMovementTable extends TableComponent
{
    public $product;

    public $checkbox = false;

    public $sort_attribute = "created_at";

    public $sort_direction = "desc";

    public function __construct($id)
    {
        parent::__construct($id);
    }

    public function mount($product = null)
    {
        $this->setTableProperties();
        $this->product = $product;
    }

    public function query()
    {
        return StockMoving::where('product_stock_id', $this->product);
    }

    public function columns()
    {
        return [
            Column::make('Perubahan', 'amount')->searchable()->sortable(),
            Column::make('Stok Awal', 'stock_before')->searchable()->sortable(),
            Column::make('Stok Akhir', 'stock_after')->searchable()->sortable(),
            Column::make('Keterangan', 'comment')->searchable()->sortable(),
            Column::make('Tanggal', 'created_at')->searchable()->sortable(),
        ];
    }
}
