<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockMovingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_movings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_stock_id')->constrained();
            $table->float('amount');
            $table->float('stock_after');
            $table->float('stock_before');
            $table->text('comment');
            $table->bigInteger('movable_id');
            $table->string('movable_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_movings');
    }
}
