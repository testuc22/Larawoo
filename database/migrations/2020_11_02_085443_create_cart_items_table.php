<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->string('sku');
            $table->float('price');
            $table->float('discount')->default(0.0);
            $table->smallInteger('quantity');
            $table->tinyInteger('active');
            $table->text('content');
            $table->timestamps();
            $table->foreignId('cart_id')
                  ->constrained()
                  ->onDelete('cascade');
            $table->foreignId('product_attribute_id')
                  ->constrained()
                  ->onDelete('cascade');     
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cart_items');
    }
}
