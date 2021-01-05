<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id');
            $table->foreignId('branch_id')->constrained('branches')->onDelete('cascade');
            $table->string('sku')->unique();
            $table->string('name');
            $table->text('desc');
            $table->double('price')->default(0);
            $table->double('buy_price')->default(0);
            $table->float('stock')->default(0);
            $table->string('image')->nullable();
            $table->string('status')->index()->default('ACTIVE')->comment('ACTIVE | INACTIVE');
            $table->timestamps();
            $table->engine = 'InnoDB';

            $table->foreign('category_id')->references('id')->on('product_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
