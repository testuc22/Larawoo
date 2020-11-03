<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('sessionId');
            $table->string('token')->nullable();
            $table->smallInteger('status');
            $table->float('subTotal');
            $table->float('itemDiscount')->default(0.0);
            $table->float('tax')->default(0.0);
            $table->float('shipping')->default(0.0);
            $table->float('total');
            $table->string('promo')->nullable();
            $table->float('discount')->default(0.0);
            $table->string('firstName');
            $table->string('lastName');
            $table->string('email');
            $table->string('line1');
            $table->string('line2')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('country');
            $table->text('content')->nullable();
            $table->timestamps();
            $table->foreignId('user_id')
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
        Schema::dropIfExists('orders');
    }
}
