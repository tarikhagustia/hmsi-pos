<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provinces', function (Blueprint $table) {

            $table->engine = 'InnoDB';
            $table->bigInteger('province_id', 1, 1)->unique();
            $table->string('province_name', 50);
            $table->string('province_name_abbr', 50);
            $table->string('province_name_id', 50);
            $table->string('province_name_en', 50);
            $table->smallInteger('province_capital_city_id')->unsigned()->index();
            $table->string('iso_code', 5)->index();
            $table->string('iso_name', 50);
            $table->enum('iso_type',
                [
                    'province',
                    'autonomous province',
                    'special district',
                    'special region',
                ]);
            $table->string('iso_geounit', 2)->index();
            $table->tinyInteger('timezone');
            $table->decimal('province_lat', 10, 6)->nullable()->index();
            $table->decimal('province_lon', 11, 6)->nullable()->index();
            $table->timestamps();
        });
        Schema::create('cities', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigInteger('city_id', 1, 1)->unique();
            $table->unsignedBigInteger('province_id');
            $table->string('city_name', 50)->index();
            $table->string('city_name_full', 100)->index();
            $table->enum('city_type', ['kabupaten', 'kota'])->nullable();
            $table->decimal('city_lat', 10, 6)->nullable()->index();
            $table->decimal('city_lon', 11, 6)->nullable()->index();
            $table->timestamps();

            $table->foreign('province_id')->references('province_id')->on('provinces');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cities');
        Schema::dropIfExists('provinces');
    }
}
