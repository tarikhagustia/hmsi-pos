<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockDemandItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_demand_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_demand_id');
            $table->foreignId('product_id');
            $table->double('requested_qty');
            $table->double('approved_qty');
            $table->timestamps();
           $table->engine = 'InnoDB';

            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('stock_demand_id')->references('id')->on('stock_demands');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_demand_items');
    }
}
