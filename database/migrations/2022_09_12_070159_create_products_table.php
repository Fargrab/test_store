<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('Наименование товара');
            $table->text('descriptions')->comment('Описание товара');
            $table->integer('count')->default(0)->comment('Количество товаров на складе');
            $table->integer('reserve')->default(0)->comment('Количество в резерве');
            $table->float('price')->comment('Цена')->nullable();
            $table->boolean('is_active')->default(1)->comment('Флаг активности продажи товара');
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
        Schema::dropIfExists('products');
    }
};
