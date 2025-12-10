<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_shipping_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_shipping_id');
            $table->unsignedBigInteger('order_payment_id');

            $table->foreign('order_shipping_id')
                ->references('id')->on('order_shippings')
                ->onDelete('cascade');

            $table->foreign('order_payment_id')
                ->references('id')->on('order_payments')
                ->onDelete('cascade');

            $table->unique(['order_shipping_id', 'order_payment_id'], 'order_shipping_payment_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_shipping_payments');
    }
};
