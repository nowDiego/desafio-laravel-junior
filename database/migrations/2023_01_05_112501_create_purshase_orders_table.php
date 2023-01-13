<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purshase_orders', function (Blueprint $table) {
            $table->id();
            $table->dateTime('dt_pedido');
            $table->integer('valor_total');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('order_status_id');
            $table->timestamps();
            $table->foreign('customer_id')->references('id')->on('customers')->cascadeOnDelete();
            $table->foreign('order_status_id')->references('id')->on('order_statuses')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purshase_orders');
    }
};
