<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockDemandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_demands', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->foreignId('from_branch_id');
            $table->foreignId('to_branch_id');
            $table->foreignId('requested_by_user_id');
            $table->text('comment')->nullable();
            $table->dateTime('approved_at')->nullable();
            $table->dateTime('rejected_at')->nullable();
            $table->dateTime('received_at')->nullable();
            $table->string('status', 10)->index();
            $table->timestamps();
           $table->engine = 'InnoDB';

            $table->foreign('from_branch_id')->references('id')->on('branches');
            $table->foreign('to_branch_id')->references('id')->on('branches');
            $table->foreign('requested_by_user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_demands');
    }
}
